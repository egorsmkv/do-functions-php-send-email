# `do-functions-php-send-email`

This function gives you the ability to send email messages via any SMTP server using own predefined HTML/TXT templates.

## Installation

```bash
doctl serverless deploy do-functions-php-send-email/ --remote-build
```

## Usage

```
curl -vvvv https://faas-fra1-afec6ce7.doserverless.co/api/v1/web/fn-44d5d42b-b766-4f5b-8975-7675502704a3/default/send-email?smtp_server=smtp.mailgun.org&smtp_port=587&smtp_username=postmaster@sandboxXXXXXXXXXXXXXXXXXXXX.mailgun.org&smtp_password=YYYYYYYYYYYYYYYY&subject=testing%20this%20feature&sender_email=postmaster@sandboxXXXXXXXXXXXXXXXXXXXXXXXXX.mailgun.org&sender_name=SomeONE&recipient_email=john@gmail.com&recipient_name=Yehor%20Smoliakov&template=hello&variables=eyJuYW1lIjoiWWVob3IifQ==
```
