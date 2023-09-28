# SMS KIT

#### Simple Library Package for sending SMS

SMS Kit is a simple PHP library for sending SMS using an API. This library provides an easy-to-use interface for sending SMS messages to recipients using your preferred SMS gateway. Currently supported API is [onewaysms](https://onewaysms.ph/)

## Install

```bash
    composer require jccdbytes/sms-kit
```

## Usage

#### Setting Up Configuration

SMS Kit allows you to configure API credentials in two ways:

1. ENV Variables
   By default, SMS Kit looks for configuration values in your project's .env file. You can set the following environment variables:

- 'SMS_API_USERNAME' : Your API username
- 'SMS_API_PASSWORD' : Your API password
- 'SMS_SENDER' : Your name or app name
- 'GW_URL' : The URL of the SMS gateway.

Example .env configuration:

```bash
    SMS_API_USERNAME=your_api_username
    SMS_API_PASSWORD=your_api_password
    SMS_SENDER=sender_name
    GW_URL=gateway_url 
```

2. Method Calls
   Alternatively, you can configure SMS Kit programmatically by calling the following method in your code:

- '$apiUsername' : Your API username
- '$apiPassword' : Your API password
- '$sender' : Your name or app name
- '$gwUrl' : The URL of the SMS gateway.

```php
    use Jccdbytes\SmsKit\SMS;
    $sms = new SMS();

    $sms->setConfig($apiUsername, $apiPassword, $sender, $gwUrl)
```

 ----or----

```php
    $sms = new \Jccdbytes\SmsKit\SMS();

    $sms->setConfig($apiUsername, $apiPassword, $sender, $gwUrl)
```

##### Other Configuration

1. Configuring the language type of the sms.
   By default it is set to number 1 = normal text. You can find number with its equivalent language type in onewaysms documentation.

- setLanguageType method only accept integer value (1, 2):

```php
    $sms->setLanguageType(1);
```

#### Sending SMS

Once configured, you can use SMS Kit to send SMS messages to recipients. Here's an example:

The number format starts with 09 plus 9 digit number
example : 09123456789

or 

using the country  code plus 10 digit number (Philippines use 63 )
exmple : 639234567891

```php
    $response = $sms->gw_send_sms('recipient_number', 'Your message');
```

The return type is an associative array with two elements.

- message : returned message from the library
- code : 0 and 1, were 1 indicates sms sent successfully and 0 if sms is not sent.
  Unsuccessful sms also returned a message together with its api code response: You can check the meaning of the api response code on [onewaysms](https://onewaysms.ph/) documentation pdf.
