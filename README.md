Shiruku
===

A Blog platform

## Description

Shiruku is a blog platform by laekov, which is originally aimed at strengthening laekov's php programming ablity.

This platform is the kind of thing like wordpress. Nevertheless, it is lighter so that any user can easily attach their private elements to his or her blog by editing the code.

Secondly, laekov wants this blog to support logging in through other log in plateforms such as Github, Tencent and so on.

What's more, laekov wants to move most of the work to the client side, using client-side javascript including jquery to do jobs like generating article views.

At last, laekov wants to reduce SQL space usage for it is very tiny on Aliyun's free server. In order to do this, most of the data are stored in the format of single files.

## Configuration
An apache2 with php and a MySQL server is needed.

You should make error page 403 and 404 redirected to /app.php, as Shiruku resolves the request URLs by itself instead of original path.

### /app/config/env.php

Contains environmental variables such as SQL server data.

### /app/config/content.php

Contains contents like category and friend links.
