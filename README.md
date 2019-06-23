# yii2-mailchimp
Yii2 Component for Mailchimp Api V3 using Curl

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist linslin/yii2-curl "*"
php composer.phar require --prefer-dist egangloff/yii2-mailchimp "dev-master"
```

or add

```
"linslin/yii2-curl": "*",
"egangloff/yii2-mailchimp": "dev-master"
```

to the require section of your `composer.json` file.


## Configuration

Setup component in `config/main.php`

```
'components' => [
        'mailchimp' => [
            'class' => Mailchimp::class,
            'apikey' => 'Your_Mailchimp_Api-Key'
        ],
    ]
```


## Use

In your controller,


```
use egangloff\mailchimp\mailchimp;

$mailchimp = new Mailchimp;
```


## Methods

Get all lists

```
    Mailchimp->getLists();
```

Get A specific list

```
    Mailchimp->getLists('<listid>')
```

Get all members from a list

```
    Mailchimp->getMembers('<listid>')
```

Get a specific member from a list

```
    Mailchimp->getLists('<listid>', '<memberid>')
```

Add a Member to a list

```
    Mailchimp->addMember('<listid>', <firstname>', '<lastname>', '<email>', '<phone>')
```

Delete a member from a list

```
    Mailchimp->deleteMember('<listid>', '<memberid>')
```


## Error Management

```
    echo 'Status Code: ' . $mailchimp->$statuscode . ' - Status Message' . $mailchimp->$statustext;
```