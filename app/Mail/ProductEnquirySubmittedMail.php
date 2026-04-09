<?php

namespace App\Mail;

use App\Models\ProductEnquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductEnquirySubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public ProductEnquiry $enquiry;

    public function __construct(ProductEnquiry $enquiry)
    {
        $this->enquiry = $enquiry;
    }

    public function build(): self
    {
        return $this->subject('New Product Enquiry - '.$this->enquiry->product_name)
            ->view('emails.product-enquiry-submitted');
    }
}
