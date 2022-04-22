<?php

namespace App\Console\Commands;

use App\Jobs\DeleteCustomer;
use App\Models\Customer;
use Illuminate\Console\Command;

class DeleteCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete 6+ months inactive customers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = \DateTime::createFromFormat('Y-m-d H:i:s', now());
        $limit = $today->sub(new \DateInterval('P6M'));

        $customers = Customer::where('updated_at', '<', $limit)
            ->get();

        $count = 0;
        foreach ($customers as $customer) {
            DeleteCustomer::dispatch($customer);
            $count++;
        }

        $this->output->write(sprintf('%d job(s) créé(s)' . PHP_EOL, $count));

        return 1;
    }
}
