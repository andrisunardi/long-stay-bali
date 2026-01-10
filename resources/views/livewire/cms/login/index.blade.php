@section('title', trans('page.login'))
@section('icon', 'fas fa-sign-in-alt')

<main>
    <div class="bg-body-secondary">
        <div class="container">
            <div class="row justify-content-center align-items-center vh-100 mt-sm-5 mt-md-auto">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-4">
                    <div class="mb-3 d-flex justify-content-center">
                        <img draggable="false" class="w-50" src="{{ asset('images/logo.png') }}"
                            alt="{{ trans('index.logo') }} - {{ config('app.name') }}">
                    </div>

                    <div class="card shadow rounded border-0 mb-sm-5 mb-md-auto">
                        <div class="card-header text-center">
                            <h5 class="card-title">{{ config('app.name') }}</h5>
                            <p class="card-text">@yield('title')</p>
                        </div>

                        <div class="card-body">
                            <form wire:submit.prevent="submit" role="form" autocomplete="off">
                                <div class="d-grid gap-3">
                                    <div class="mb-3">
                                        {{-- <x-form.username :key="'form.username'" :maxlength="50"
                                            :required="true" :autocapitalize="'none'" :autofocus="true" /> --}}
                                    </div>

                                    <div class="mb-3">
                                        {{-- <x-form.password :key="'form.password'" :maxlength="50"
                                            :required="true" :autocapitalize="'none'" /> --}}
                                    </div>

                                    <div class="mb-3">
                                        {{-- <x-form.boolean :key="'form.remember'" :title="trans('validation.attributes.remember')"
                                            :type="'checkbox'" :text="trans('index.stay_login')" :second="false" :required="false"
                                            :label="false" /> --}}
                                    </div>

                                    <div class="row align-items-center justify-content-between">
                                        <div class="col">
                                            {{-- <x-link :class="'small text-decoration-none'" :text="trans('index.forgot_password')"
                                                :href="route('cms.forgot-password')" /> --}}
                                        </div>
                                        <div class="col">
                                            {{-- <x-form.submit :text="trans('index.login')" :icon="'fas fa-sign-in-alt'" /> --}}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card-footer text-center">
                            <small class="text-body-secondary">
                                &copy; {{ trans('footer.copyright') }}
                                {{ env('APP_YEAR') && env('APP_YEAR') != now()->year ? env('APP_YEAR') . ' - ' : null }}
                                {{ now()->year }} &reg;
                                <a draggable="false" href="{{ route('index') }}" target="_blank"
                                    class="text-body text-decoration-none">
                                    <strong>{{ env('APP_NAME') }}</strong>&trade;
                                </a>
                                <br />
                                {{ trans('footer.all_rights_reserved') }}.
                            </small>
                            <br>
                            <small class="text-body-secondary">
                                {{ trans('footer.created_and_designed_by') }}
                                <a draggable="false" href="https://www.diw.co.id" target="_blank">
                                    <img draggable="false" src="{{ asset('images/icon-diw.co.id.png') }}"
                                        alt="Icon DIW.co.id"
                                        title="{{ trans('footer.created_and_designed_by') }} DIW.co.id">
                                </a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
