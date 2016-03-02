# PHP BigBlueButton API Library

> BigBlueButton is an open source web conferencing system for on-line learning. – http://www.bigbluebutton.org

This is a php library to interface with a BigBlueButton server instance.

## Installation

Get [Composer](https://getcomposer.org/) and install it.
Then clone the repository and run:

    composer install

## Usage

To get your API URL and secret login to your BigBlueButton server and run:

    $ bbb-conf --secret
           URL: http://example.org/bigbluebutton/
        Secret: aiShaiteih6nahchie1quaiyul8ce4Zu

Initialize a BigBlueButton object:

    <?php

    require_once 'vendor/autoload.php';

    use sanduhrs\BigBlueButton;

    $bbb = new BigBlueButton(
        'http://example.org/bigbluebutton/',
        'aiShaiteih6nahchie1quaiyul8ce4Zu',
        'api/'
    );

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
              'record' = true,
              'autoStartRecording' = true,
        ]
    );

Get meeting join URL for a moderator:

    $full_name = 'Martin Moderator';
    $url = $meeting->join($full_name, true);

Get meeting join URL for an attendee:

    $full_name = 'Anton Attendee';
    $url = $meeting->join($full_name);

## Tests

    ./vendor/bin/phpunit

## License
GNU GENERAL PUBLIC LICENSE (GPL)
