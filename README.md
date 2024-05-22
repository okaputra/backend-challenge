<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Step 1: Clone the GitHub Repository

git clone <https://github.com/okaputra/backend-challenge.git>

## Step 2: Install Composer Dependencies / Update if necessary

    composer install 
    composer update

## Step 3: Set Up the .env File

     cp .env.example .env

## Generate Application Key: 

    php artisan key:generate

## Configure the .env File:

Open the .env file and configure the following settings:

    Database settings (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
    Mail settings for email verification (MAIL_MAILER, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD, MAIL_ENCRYPTION, MAIL_FROM_ADDRESS, MAIL_FROM_NAME)
    OAuth settings for Google and Facebook (you'll get these credentials in the next steps):

    GOOGLE_CLIENT_ID=your-google-client-id
    GOOGLE_CLIENT_SECRET=your-google-client-secret
    GOOGLE_REDIRECT_URL=your-google-redirect-url
    
    FACEBOOK_CLIENT_ID=your-facebook-client-id
    FACEBOOK_CLIENT_SECRET=your-facebook-client-secret
    FACEBOOK_REDIRECT_URL=your-facebook-redirect-url

## Step 4: Configure Database

    php artisan migrate

## Step 5: Get Google and Facebook OAuth Credentials

Google OAuth Credentials:

1. Go to the Google Developer Console.
2. Create a new project.
3. Navigate to the OAuth consent screen and configure it.
4. Go to Credentials and create OAuth 2.0 Client IDs.
5. Configure the Authorized redirect URIs (e.g., http://your-domain.com/auth/google/callback).
6. Copy the Client ID and Client Secret and paste them into the .env file.

Facebook OAuth Credentials:

1. Go to the Facebook Developers.
2. Create a new app.
3. Go to Settings > Basic and fill in the necessary details.
4. Navigate to Add a Product and select Facebook Login.
5. Configure the Valid OAuth Redirect URIs (e.g., http://your-domain.com/auth/facebook/callback).
6. Copy the App ID and App Secret and paste them into the .env file.

## Step 8: Serve the Application

    php artisan serve

