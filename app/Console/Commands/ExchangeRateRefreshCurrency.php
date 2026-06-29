<?php

namespace App\Console\Commands;

use App\Enums\Currency;
use App\Libraries\ExchangeRate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ExchangeRateRefreshCurrency extends Command
{
    protected $signature = 'exchange-rate:refresh-currency';

    protected $description = 'Exchange Rate Refresh Currency';

    public function handle(): bool
    {
        $currencies = collect(Currency::cases())->reject(fn ($q) => $q == Currency::IDR);

        $exchangeRate = (new ExchangeRate)->index(currency: Currency::IDR->value);

        foreach ($currencies as $currency) {
            Cache::put(
                "currency-{$currency->value}",
                $exchangeRate['conversion_rates'][strtoupper($currency->value)],
                now()->endOfDay(),
            );
        }

        $this->info('Currency is Refreshed.');
        Log::info('Currency is Refreshed.');

        return Command::SUCCESS;
    }
}
