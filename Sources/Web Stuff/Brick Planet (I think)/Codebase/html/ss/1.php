
<?php

// Replace the URL with your own webhook url
$url = "https://discordapp.com/api/webhooks/582912112037330944/ve-WzbXBNZB52__00565bIWOwJwZ2fHf2miQsHhdqngB9ae7b1xCksamnrAJwtH1ITPs";

$hookObject = json_encode([
    /*
     * The general "message" shown above your embeds
     */
    "content" => "@everyone Our first tokens item has been released, Remmember you can get lots of tokens when you buy a membership.",
    /*
     * The username shown in the message
     */
    "username" => "Kaverti Catalog Notifier",
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
            "title" => "Golden Top Hat",

            // The type of your embed, will ALWAYS be "rich"
            "type" => "rich",

            // A description for your embed
            "description" => "Quality Style, Oh yeaaa!",

            // The URL of where your title will be a link to
            "url" => "https://kaverti.com/store/item.php?id=40",

            // The integer color to be used on the left side of the embed
            "color" => hexdec( "2185d0" ),

            // Footer object
            "footer" => [
                "text" => "Kaverti Corporation",
                "icon_url" => "https://i.imgur.com/PHKOeKy.png"
            ],
            

            // Image object
            "image" => [
                "url" => "https://cdn.discordapp.com/attachments/550128968674705422/585908620135366656/s40.png"
            ],

            // Thumbnail object
            "thumbnail" => [
                "url" => "https://i.imgur.com/PHKOeKy.png"
            ],

            // Author object
            "author" => [
                "name" => "Kaverti",
                "url" => "https://kaverti.com/profile.php?id=1"
            ],

            // Field array of objects
            "fields" => [
                // Field 1
                [
                    "name" => "Item",
                    "value" => "Golden Top Hat",
                    "inline" => false
                ],
                // Field 2
                [
                    "name" => "Price",
                    "value" => "50 Tokens",
                    "inline" => true
                ],
                // Field 3
                [
                    "name" => "Creator",
                    "value" => "Kaverti",
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