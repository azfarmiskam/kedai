<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            // Website Hosting Plans
            [
                'name' => 'Free',
                'slug' => 'free',
                'description' => '1-month trial with basic landing page',
                'price' => 0.00,
                'currency' => 'RM',
                'billing_period' => 'monthly',
                'plan_type' => 'website',
                'product_limit' => 0,
                'custom_domain' => false,
                'remove_trademark' => false,
                'email_accounts' => 0,
                'priority_support' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Perfect for getting started with your online presence',
                'price' => 19.00,
                'currency' => 'RM',
                'billing_period' => 'monthly',
                'plan_type' => 'website',
                'product_limit' => 0,
                'custom_domain' => false,
                'remove_trademark' => false,
                'email_accounts' => 0,
                'priority_support' => false,
                'sort_order' => 2,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'For professionals who want a custom domain',
                'price' => 79.00,
                'currency' => 'RM',
                'billing_period' => 'monthly',
                'plan_type' => 'website',
                'product_limit' => 0,
                'custom_domain' => true,
                'remove_trademark' => true,
                'email_accounts' => 5,
                'priority_support' => false,
                'sort_order' => 3,
            ],
            // E-commerce Hosting Plans
            [
                'name' => 'Launch',
                'slug' => 'launch',
                'description' => 'Launch your e-commerce store with essential features',
                'price' => 69.00,
                'currency' => 'RM',
                'billing_period' => 'monthly',
                'plan_type' => 'ecommerce',
                'product_limit' => 2,
                'custom_domain' => false,
                'remove_trademark' => false,
                'email_accounts' => 1,
                'priority_support' => false,
                'sort_order' => 4,
            ],
            [
                'name' => 'Grow',
                'slug' => 'grow',
                'description' => 'Grow your business with more products and custom domain',
                'price' => 99.00,
                'currency' => 'RM',
                'billing_period' => 'monthly',
                'plan_type' => 'ecommerce',
                'product_limit' => 5,
                'custom_domain' => true,
                'remove_trademark' => false,
                'email_accounts' => 1,
                'priority_support' => false,
                'sort_order' => 5,
            ],
            [
                'name' => 'Scale',
                'slug' => 'scale',
                'description' => 'Scale your business with priority support and more products',
                'price' => 399.00,
                'currency' => 'RM',
                'billing_period' => 'monthly',
                'plan_type' => 'ecommerce',
                'product_limit' => 20,
                'custom_domain' => true,
                'remove_trademark' => true,
                'email_accounts' => 5,
                'priority_support' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($plans as $plan) {
            \App\Models\SubscriptionPlan::create($plan);
        }
    }
}
