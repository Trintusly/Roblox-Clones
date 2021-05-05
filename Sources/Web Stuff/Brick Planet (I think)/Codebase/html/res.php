
<?php

// Replace the URL with your own webhook url
$url = "https://discordapp.com/api/webhooks/601802923319754792/dCuJYZS3qKiIpf-VwkyEL8eo-gcBOaA8sSgJ9nnjGr_Tx9miJ67FFqOhFXi5soH8i9qT";

$hookObject = json_encode([
    /*
     * The general "message" shown above your embeds
     */
    "content" => "@everyone",
    /*
     * The username shown in the message
     */
    "username" => "Brick Create",
    /*
     * The image location for the senders image
     */
    "avatar_url" => "",
    /*
     * Whether or not to read the message in Text-to-speech
     */
    "tts" => false,
    /*
     * File contents to send to upload a file
     */
    // "file" => "",
    /*
     * An array of Embeds
     */
    "embeds" => [
        /*
         * Our first embed
         */
        [
            // Set the title for your embed
            "title" => "Site Closed",

            // The type of your embed, will ALWAYS be "rich"
            "type" => "rich",

            // A description for your embed
            "description" => "I'm afraid due to the circumstances, We will not be using the Brick Planet source anymore, Our CEO Wind was just threatened with a legal action from the owners, This is where we have to draw the line, The site is being closed right now and we'll upload our source from a few months ago, We do apologise to Brick Planet Inc.",

            // The URL of where your title will be a link to
            "url" => "https://brickcreate.com",

            // The integer color to be used on the left side of the embed
            "color" => hexdec( "2185d0" ),

            // Footer object
            "footer" => [
                "text" => "© Copyright 2019 Brick Create, Inc. All rights reserved.",
                "icon_url" => "https://i.imgur.com/x7iuXxz.png"
            ],
            

            

            // Thumbnail object
            "thumbnail" => [
                "url" => ""
            ],

            // Author object
            "author" => [
                "name" => "Brick Create",
                "url" => "https://brickcreate.com"
            ],

            // Field array of objects
            "ram" => [
                // Field 1
                [
                    "name" => "⠀⠀⠀⠀⠀⠀⠀",
                    "value" => "⠀⠀⠀⠀⠀⠀⠀",
                    "inline" => true
                ],
                // Field 2
                [
                    "name" => "⠀⠀⠀⠀⠀⠀⠀",
                    "value" => "⠀⠀⠀⠀⠀⠀⠀",
                    "inline" => true
                ],
                // Field 3
                [
                    "name" => "⠀⠀⠀⠀⠀⠀⠀",
                    "value" => "⠀⠀⠀⠀⠀⠀⠀",
                    "inline" => true
                ]
            ]
        ]
    ]

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

$ch = curl_init();

curl_setopt_array( $ch, [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $hookObject,
    CURLOPT_HTTPHEADER => [
        "Length" => strlen( $hookObject ),
        "Content-Type" => "application/json"
    ]
]);

$response = curl_exec( $ch );
curl_close( $ch );

?>