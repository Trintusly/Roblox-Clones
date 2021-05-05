
<?php

// Replace the URL with your own webhook url
$url = "https://discord.gg/JDXJsq";

$hookObject = json_encode([
    /*
     * The general "message" shown above your embeds
     */
    "content" => "",
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
            "title" => "**Brick Create Discord Rules:**",

            // The type of your embed, will ALWAYS be "rich"
            "type" => "rich",

            // A description for your embed
            "description" => "**Brick Create Discord Rules:** 

Use common sense.

Do not spam.

Do not leak personal information about yourself or anyone else.

Do not personally attack other users.

Do not post Discord server or offsite links. 

Do not DM advertise Discord servers or other communities.

Do not ping staff members unless it is necessary.

No offensive or excessive use of profanity.

Do not impersonate other users or staff members.

Do not post or discuss sexual content.

Abide by Discord’s Terms of Service.

Abide by the Brick Create Terms of Service.


Brick Create Terms of Service: 
https://www.brickcreate.com.com/about/terms-of-service/",

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
                "url" => "https://i.imgur.com/AOH6Kd0.gif"
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