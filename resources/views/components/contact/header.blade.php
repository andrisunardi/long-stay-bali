<section class="py-5">
    <div class="container-md">
        <div class="row g-4">
            <div class="col-lg-4">
                {{-- prettier-ignore --}}
                <x-contact.info
                :whatsapp="config('constants.contact.whatsapp')"
                :email="config('constants.contact.email')"
                />
            </div>
            <div class="col-lg-8 col-xl-7 offset-xl-1">
                @livewire('contact.form')
            </div>
        </div>
    </div>
</section>
