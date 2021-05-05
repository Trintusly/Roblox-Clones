
<?php

// Replace the URL with your own webhook url
$url = "https://discordapp.com/api/webhooks/582912112037330944/ve-WzbXBNZB52__00565bIWOwJwZ2fHf2miQsHhdqngB9ae7b1xCksamnrAJwtH1ITPs";

$hookObject = json_encode([
    /*
     * The general "message" shown above your embeds
     */
    "content" => "@everyone A new item has been released in the catalog!",
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
            "title" => "Donator's Chain",

            // The type of your embed, will ALWAYS be "rich"
            "type" => "rich",

            // A description for your embed
            "description" => "Bling Bling. This item is awarded to users who have donated at least £2 to Kaverti.",

            // The URL of where your title will be a link to
            "url" => "https://kaverti.com/store/item.php?id=38",

            // The integer color to be used on the left side of the embed
            "color" => hexdec( "2185d0" ),

            // Footer object
            "footer" => [
                "text" => "Kaverti Corporation",
                "icon_url" => "https://i.imgur.com/PHKOeKy.png"
            ],
            

            // Image object
            "image" => [
                "url" => "https://media.discordapp.net/attachments/550128968674705422/585881218642477093/s38.png"
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
                    "value" => "Donator's Chain",
                    "inline" => false
                ],
                // Field 2
                [
                    "name" => "Price",
                    "value" => "Offsale",
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