<?php

namespace App\Filament\Resources\Invoice\InvoiceResource\Pages;

use App\Filament\Resources\Invoice\InvoiceResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\SmsMessage;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use App\Models\Invoice;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If replaced_items_table is present, split it into three arrays
        if (isset($data['replaced_items_table']) && is_array($data['replaced_items_table'])) {
            $items = [];
            $brands = [];
            $prices = [];
            foreach ($data['replaced_items_table'] as $row) {
                $items[] = $row['item'] ?? '';
                $brands[] = $row['brand'] ?? '';
                $prices[] = $row['price'] ?? '';
            }
            $data['replaced_items'] = $items;
            $data['replaced_items_brand'] = $brands;
            $data['replaced_items_prices'] = $prices;
        }
        return $data;
    }

    protected function afterCreate(): void
    {
        $invoice = $this->record;
        $repair = $invoice->repair;
        $customer = $repair?->customer;
        if (!$customer || !$customer->phone) {
            Log::error('SMS not sent: Customer or phone missing for invoice', ['invoice_id' => $invoice->id]);
            return;
        }
        $phone = $customer->phone;
        $name = $customer->name;
        $link = route('invoice.print', $invoice->id);
        $body = "Hello ($name) thanks for chose us here your invoice link: $link";

        // Save to SmsMessage for tracking
        $sms = SmsMessage::create([
            'customer_id' => $customer->id,
            'phone' => $phone,
            'body' => $body,
            'send_at' => now(),
            'status' => 'queued',
        ]);

        // Send SMS via Twilio
        try {
            $sid = config('services.twilio.sid');
            $token = config('services.twilio.token');
            $from = config('services.twilio.from');
            $twilio = new Client($sid, $token);
            $message = $twilio->messages->create($phone, [
                'from' => $from,
                'body' => $body,
            ]);
            $sms->update([
                'status' => 'sent',
                'provider_message_id' => $message->sid,
            ]);
        } catch (\Exception $e) {
            $sms->update([
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]);
            Log::error('Twilio SMS send failed', ['error' => $e->getMessage(), 'invoice_id' => $invoice->id]);
        }
    }
}
