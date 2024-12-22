<?php

namespace App\Mail;

use App\Models\Applicant;
use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class JobApplied extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @param Applicant $application
     * @param Job $job
     */
    public function __construct(
        protected Applicant $application,
        protected Job $job,
    )
    {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Job Application',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.job-applied',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments =  [];
        if ($this->application->resume_path) {
            $attachments[] = Attachment::fromPath(storage_path('app/public/' . $this->application->resume_path))
                ->as($this->application->resume_path)
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
