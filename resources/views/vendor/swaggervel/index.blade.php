<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

$client = DB::table('oauth_clients')->where('password_client', 1)->first();
?>
        <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Swagger UI</title>
    <link rel="icon" type="image/png" href="/vendor/swaggervel/images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/vendor/swaggervel/images/favicon-16x16.png" sizes="16x16" />
    <link href='/vendor/swaggervel/css/typography.css' media='screen' rel='stylesheet' type='text/css'/>
    <link href='/vendor/swaggervel/css/reset.css' media='screen' rel='stylesheet' type='text/css'/>
    <link href='/vendor/swaggervel/css/screen.css' media='screen' rel='stylesheet' type='text/css'/>
    <link href='/vendor/swaggervel/css/reset.css' media='print' rel='stylesheet' type='text/css'/>
    <link href='/vendor/swaggervel/css/print.css' media='print' rel='stylesheet' type='text/css'/>

    <script src='/vendor/swaggervel/lib/object-assign-pollyfill.js' type='text/javascript'></script>
    <script src='/vendor/swaggervel/lib/jquery-1.8.0.min.js' type='text/javascript'></script>
    <script src='/vendor/swaggervel/lib/jquery.slideto.min.js' type='text/javascript'></script>
    <script src='/vendor/swaggervel/lib/jquery.wiggle.min.js' type='text/javascript'></script>
    <script src='/vendor/swaggervel/lib/jquery.ba-bbq.min.js' type='text/javascript'></script>
    <script src='/vendor/swaggervel/lib/handlebars-4.0.5.js' type='text/javascript'></script>
    <script src='/vendor/swaggervel/lib/lodash.min.js' type='text/javascript'></script>
    <script src='/vendor/swaggervel/lib/backbone-min.js' type='text/javascript'></script>
    <script src='/vendor/swaggervel/swagger-ui.min.js' type='text/javascript'></script>
    <script src='/vendor/swaggervel/lib/highlight.9.1.0.pack.js' type='text/javascript'></script>
    <script src='/vendor/swaggervel/lib/highlight.9.1.0.pack_extended.js' type='text/javascript'></script>
    <script src='/vendor/swaggervel/lib/jsoneditor.min.js' type='text/javascript'></script>
    <script src='/vendor/swaggervel/lib/marked.js' type='text/javascript'></script>
    <script src='/vendor/swaggervel/lib/swagger-oauth.js' type='text/javascript'></script>

    <!-- Some basic translations -->
    <!-- <script src='lang/translator.js' type='text/javascript'></script> -->
    <!-- <script src='lang/ru.js' type='text/javascript'></script> -->
    <!-- <script src='lang/en.js' type='text/javascript'></script> -->

    <script type="text/javascript">
        $(function () {
            var url = window.location.search.match(/url=([^&]+)/);
            if (url && url.length > 1) {
                url = decodeURIComponent(url[1]);
            } else {
                url = "{!! $urlToDocs !!}";
            }

            hljs.configure({
                highlightSizeThreshold: 5000
            });

            // Pre load translate...
            if(window.SwaggerTranslator) {
                window.SwaggerTranslator.translate();
            }
            window.swaggerUi = new SwaggerUi({
                url: url,
                dom_id: "swagger-ui-container",
                supportedSubmitMethods: ['get', 'post', 'put', 'delete', 'patch'],
                onComplete: function(swaggerApi, swaggerUi){

                    @if (isset($requestHeaders))
                    @foreach($requestHeaders as $requestKey => $requestValue)
                    window.authorizations.add("{!!$requestKey!!}", new ApiKeyAuthorization("{!!$requestKey!!}", "{!!$requestValue!!}", "header"));
                    @endforeach
                            @endif

                    if(window.SwaggerTranslator) {
                        window.SwaggerTranslator.translate();
                    }

                    //addApiKeyAuthorization();
                },
                onFailure: function(data) {
                    log("Unable to Load SwaggerUI");
                },
                docExpansion: "none",
                jsonEditor: false,
                defaultModelRendering: 'schema',
                showRequestHeaders: false
            });

            window.swaggerUi.load();

            function log() {
                if ('console' in window) {
                    console.log.apply(console, arguments);
                }
            }

            function addApiKeyAuthorization() {
                var key = encodeURIComponent($('#input_apiKey')[0].value);
                if (key && key.trim() != "") {
                    var apiKeyAuth = new SwaggerClient.ApiKeyAuthorization("Authorization", "Bearer " + key, "header");
                    window.swaggerUi.api.clientAuthorizations.add("bearer", apiKeyAuth);
                    log("added bearer token " + key);
                }
            }

            //$('#input_apiKey').change(addApiKeyAuthorization);
        });

        $(function () {
            var sw = window.swaggerUi;
            var user = JSON.parse(localStorage.getItem("user"));

            function getName(username) {
                return 'Log Out <small>' + username + '</small>';
            }

            if (user) {
                $('.logout-button a').html(getName(user.username));
                $('.logout-button').show();
                sw.api.clientAuthorizations.add('Authorization', new window.SwaggerClient.ApiKeyAuthorization('Authorization', user.token, 'header'));
                sw.api.clientAuthorizations.remove('api_key');
            } else {
                $('.logout-button').hide();
            }

            $('#input_apiKey').change(function () {
                var key = $('#input_apiKey')[0].value;
                var credentials = key.split(':'); // username:password expected
                var tokenUrl = sw.api.securityDefinitions.oauth2.tokenUrl;
                var apiUrl = sw.api.scheme + "://" + sw.api.host + sw.api.basePath;

                if (credentials.length != 2) {
                    return;
                }
                var clientSecret = "{{$client->secret}}";
                var clientId = "{{$client->id}}";
                $.ajax({
                    url: tokenUrl,
                    type: "post",
                    contenttype: 'x-www-form-urlencoded',
                    data: "client_id=" + clientId + "&client_secret=" + clientSecret + "&resource=" + apiUrl + "&grant_type=password&username=" + credentials[0] + "&password=" + credentials[1],
                    success: function (response) {
                        var bearerToken = {
                            token: 'Bearer ' + response.access_token,
                            username: credentials[0]
                        };
                        sw.api.clientAuthorizations.remove('Authorization');
                        sw.api.clientAuthorizations.add('Authorization', new window.SwaggerClient.ApiKeyAuthorization('Authorization', bearerToken.token, 'header'));
                        sw.api.clientAuthorizations.remove('api_key');
                        localStorage.setItem("user", JSON.stringify(bearerToken));
                        $('#input_apiKey').val('');
                        $('.logout-button a').html(getName(bearerToken.username));
                        $('.logout-button').show();
                        console.log("Login Succesfull!");
                    },
                    error: function (xhr, ajaxoptions, thrownerror) {
                        console.log("Login failed!");
                    }
                });
            });

            $('.logout-button').click(function(){
                $('.logout-button a').html('Log Out');
                localStorage.removeItem('user');
                sw.api.clientAuthorizations.remove('Authorization');
                $(this).hide();
            });
        });
    </script>
</head>

<body class="swagger-section">
<div id='header'>
    <div class="swagger-ui-wrap">
        <!--a id="logo" href="http://swagger.io"><span class="logo__title">swagger</span></a-->
        <form id='api_selector'>
            <div class='input'><input placeholder="http://example.com/api" id="input_baseUrl" name="baseUrl" type="text"/></div>
            <div class='input'><input placeholder="bearer" id="input_apiKey" name="apiKey" type="text"/></div>
            <div class='input'><a id="explore" class="header__btn" href="#" data-sw-translate>Explore</a></div>
            <div class='input logout-button'><a id="logout" class="header__btn logout" href="#" data-sw-translate>Log Out</a></div>
        </form>
    </div>
</div>

<div id="message-bar" class="swagger-ui-wrap" data-sw-translate>&nbsp;</div>
<div id="swagger-ui-container" class="swagger-ui-wrap"></div>
</body>
</html>