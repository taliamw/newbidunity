<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-12 col-md-8">
                <!-- Profile Photo File Input -->
                <input type="file" class="d-none"
                       wire:model="photo"
                       x-ref="photo"
                       x-on:change="
                           photoName = $refs.photo.files[0].name;
                           const reader = new FileReader();
                           reader.onload = (e) => {
                               photoPreview = e.target.result;
                           };
                           reader.readAsDataURL($refs.photo.files[0]);
                       " />

                <x-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="!photoPreview">
                    <img src="{{ Storage::url($this->user->profile_photo_path) }}" alt="{{ $this->user->name }}" class="rounded-circle h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="d-block rounded-circle w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(' + photoPreview + ');'">
                    </span>
                </div>

                <button type="button" class="btn btn-secondary mt-2 mr-2" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </button>

                @if ($this->user->profile_photo_path)
                    <button type="button" class="btn btn-secondary mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-12 col-md-8">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="mt-1 form-control" wire:model.defer="state.name" autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-12 col-md-8">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 form-control" wire:model.defer="state.email" autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-muted mt-2">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="btn btn-link p-0" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p v-show="verificationLinkSent" class="mt-2 font-weight-bold text-success">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>

        <!-- Payment Details Section -->
        <div class="col-12 col-md-8">
            <h2 class="h5 font-weight-bold">{{ __('Payment Details') }}</h2>

            @if (auth()->user()->card_brand && auth()->user()->card_last4)
                <p><strong>{{ __('Card Brand') }}:</strong> {{ auth()->user()->card_brand }}</p>
                <p><strong>{{ __('Card Number') }}:</strong> ****{{ auth()->user()->card_last4 }}</p><br>
                <a href="{{ route('payment-details.edit') }}" class="text-primary">{{ __('Edit Payment Details') }}</a>
            @else
                <p>{{ __('No payment details on file.') }}</p><br>
                <a href="{{ route('payment-details.edit') }}" class="text-primary">{{ __('Add Payment Details') }}</a>
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </button>
    </x-slot>
</x-form-section>
