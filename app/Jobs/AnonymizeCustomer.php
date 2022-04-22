<?php

namespace App\Jobs;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Faker;

class AnonymizeCustomer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Customer instance.
     *
     * @var \App\Models\Customer
     */
    protected $customer;

    /**
     * Create a new job instance.
     *
     * @param  App\Models\Customer $customer
     * @return void
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $faker = Faker\Factory::create();

        $this->customer->first_name = $faker->firstName();
        $this->customer->phone = '0' . rand(600000000, 799999999);
        $this->customer->email = $faker->email();
        $this->customer->is_anonymized = 1;
        $this->customer->save();
    }
}
