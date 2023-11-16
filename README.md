# Assignment
## _v1.2.0_

We’d like you to create a small e-commerce application for us to get some insights in your skillset. Focus on the PHP and especially the separation of concern, the UI is optional. Please dont spend more than two hours on this assignment.

# Don’ts
- Don't spend more than two hours
- Do not include new packages

# Installation
- `git clone git@github.com:Orderchamp/assignment.git`
- `composer install`
- `php artisan serve`

# Extra Installation
- To generate fake product data in Laravel, run the command php artisan db:seed.
-- To send a discount code after 15 minutes with email using Laravel queues, follow these steps:
- Update the .env file to add the email server configuration.
- Change the QUEUE_CONNECTION in the .env file from ASYNC to database.
- Start the queue worker by running php artisan queue:work.


# Description
Our users should be able to add products that are in stock to their shopping cart. During checkout, our visitors should be able to become users and our users should be able to review their previously stored information (name, address, contact details).

Fifteen minutes after checkout, a user should receive a discount code of € 5,- for future purchases. If a user chooses to use a discount code, you should keep track of what discount code was applied and what amount was subtracted from the checkout.

# Out-of-scope
The UI is optional. Payments in this application are based on invoices. Invoices are out of scope :-)


