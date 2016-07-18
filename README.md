# PHP BigBlueButton API Library

> BigBlueButton is an open source web conferencing system for on-line learning. – http://www.bigbluebutton.org

This is a php library to interface with a BigBlueButton server instance.

## Supported PHP-FIG Recommendations

  * PSR-1: Basic Coding Standard  
    http://www.php-fig.org/psr/psr-1/
  * PSR-2: Coding Style Guide  
    http://www.php-fig.org/psr/psr-2/
  * PSR-4: Improved Autoloading  
    http://www.php-fig.org/psr/psr-4/

## Installation

This package is [Composer](https://getcomposer.org/) compatible.
[Install Composer](https://getcomposer.org/) on your system to use it.
The run

    composer require sanduhrs/php-bigbluebutton

## Coniguration

To get your API URL and secret login to your BigBlueButton server and run:

    $ bbb-conf --secret
           URL: http://example.org/bigbluebutton/
        Secret: aiShaiteih6nahchie1quaiyul8ce4Zu

## Usage

Initialize a BigBlueButton object:

    <?php

    require_once 'vendor/autoload.php';

    use sanduhrs\BigBlueButton;

    $url = 'http://192.168.25.92/bigbluebutton/';
    $secret = '2f63eb730e7956af60351e8f4ad413d4';
    $endpoint = 'api/';
    
    // Initialize a BigBlueButton object.
    $bbb = new BigBlueButton($url, $secret, $endpoint);

Get the version of the remote server:

    $version = $bbb->server->getVersion();
    print "$version\n";

Add a meeting:

    $meeting = $bbb->server->addMeeting(
          '123-456-789-000',
          'Guphei4i',
          'ioy9Xep9',
          [
              'name' => 'A BigBlueButton meeting',
              'welcome' => 'Welcome to %%CONFNAME%%.',
              'logoutURL' => 'https://example.org/',
              'record' => true,
              'autoStartRecording' => true,
        ]
    );

Get meeting join URL for a moderator:

    $full_name = 'Martin Moderator';
    $url = $meeting->join($full_name, true);

Get meeting join URL for an attendee:

    $full_name = 'Anton Attendee';
    $url = $meeting->join($full_name);

## Full Usage Example

Initialize your project with Composer:

    composer init

Install this package and its dependencies:

    composer require sanduhrs/php-bigbluebutton

Copy this to a file called 'index.php', adjust the '$url' and '$secret' variables, then try out your setup:

    <?php
    
    require_once 'vendor/autoload.php';
    
    use sanduhrs\BigBlueButton;
    
    $url = 'http://192.168.25.92/bigbluebutton/';
    $secret = '2f63eb730e7956af60351e8f4ad413d4';
    $endpoint = 'api/';
    
    // Initialize a BigBlueButton object.
    $bbb = new BigBlueButton($url, $secret, $endpoint);
    
    // Get the version of the remote server.
    $version = $bbb->server->getVersion();
    print "$version<br />\n";
    
    // Add a meeting.
    $meeting = $bbb->server->addMeeting(
      '123-456-789-000',
      'Guphei4i',
      'ioy9Xep9',
      [
        'name' => 'A BigBlueButton meeting',
        'welcome' => 'Welcome to %%CONFNAME%%.',
        'logoutURL' => 'https://example.org/',
        'record' => true,
        'autoStartRecording' => true,
      ]
    );
    print '<pre>' . print_r($meeting, true) . "</pre>\n\n";
    
    // Get meeting join URL for a moderator.
    $full_name = 'Martin Moderator';
    $url = $meeting->join($full_name, true);
    print "Hi $full_name, you are a moderator. Please join the call via $url<br />\n\n";
    
    // Get meeting join URL for an attendee:
    $full_name = 'Anton Attendee';
    $url = $meeting->join($full_name);
    print "Hi $full_name, you are an attendee. Please join the call via $url<br />\n\n";

## Tests

    export BBB_URI=http://192.168.25.99/bigbluebutton/
    export BBB_SECRET=afb572b271cab1bc0b2262a9d5b6d981
    export BBB_ENDPOINT=api/
    ./vendor/bin/phpunit

## License
GNU GENERAL PUBLIC LICENSE (GPL)
