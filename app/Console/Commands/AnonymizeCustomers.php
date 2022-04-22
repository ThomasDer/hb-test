<?php

namespace App\Console\Commands;

use App\Jobs\AnonymizeCustomer;
use App\Models\Customer;
use Illuminate\Console\Command;

class AnonymizeCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:anonymize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Anonymize 1+ months deleted customers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = \DateTime::createFromFormat('Y-m-d H:i:s', now());
        $limit = $today->sub(new \DateInterval('P1M'));

        $customers = Customer::onlyTrashed()
            ->where('deleted_at', '<', $limit)
            ->where('is_anonymized', 0)
            ->get();

        $count = 0;
        foreach ($customers as $customer) {
            AnonymizeCustomer::dispatch($customer);
            $count++;
        }

        $this->output->write(sprintf('%d job(s) créé(s)' . PHP_EOL, $count));

        return 1;
    }
}
