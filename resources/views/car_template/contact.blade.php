@extends('car_template.base')

@section('title', 'Contact Us')

@section('content')
<section style="padding: 3rem 0;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: bold; margin-bottom: 1rem;">Contact Us</h1>
        <p style="color: var(--text-muted-color); margin-bottom: 3rem;">
            Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
        </p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;">
            <!-- Contact Form -->
            <div>
                @livewire('car.contact-form')
            </div>

            <!-- Contact Information -->
            <div>
                <div class="card" style="margin-bottom: 1.5rem;">
                    <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">Get in Touch</h2>

                    <div style="display: flex; align-items: start; margin-bottom: 1.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 24px; margin-right: 1rem; color: var(--primary-color);">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        <div>
                            <h3 style="font-weight: 600; margin-bottom: 0.25rem;">Email</h3>
                            <p style="color: var(--text-muted-color);">support@carselling.com</p>
                        </div>
                    </div>

                    <div style="display: flex; align-items: start; margin-bottom: 1.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 24px; margin-right: 1rem; color: var(--primary-color);">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                        <div>
                            <h3 style="font-weight: 600; margin-bottom: 0.25rem;">Phone</h3>
                            <p style="color: var(--text-muted-color);">+1 (555) 123-4567</p>
                        </div>
                    </div>

                    <div style="display: flex; align-items: start;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 24px; margin-right: 1rem; color: var(--primary-color);">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        <div>
                            <h3 style="font-weight: 600; margin-bottom: 0.25rem;">Address</h3>
                            <p style="color: var(--text-muted-color);">123 Car Street<br>Auto City, AC 12345</p>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">Business Hours</h2>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span>Monday - Friday</span>
                        <span style="font-weight: 600;">9:00 AM - 6:00 PM</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span>Saturday</span>
                        <span style="font-weight: 600;">10:00 AM - 4:00 PM</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Sunday</span>
                        <span style="font-weight: 600;">Closed</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
