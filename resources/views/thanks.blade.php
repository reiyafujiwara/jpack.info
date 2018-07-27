<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Fujiwara</title>

        

        <!-- Styles -->
       
    </head>
    <body>
    <div class="container clearfix">
        
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <h2>Jボックスお申込完了</h2>
            </div>
            <div class="col-xs-10 col-xs-offset-1">
        
        {% if flash['errors'] %}
            <div class="alert alert-danger">
            {% for e in flash.errors %}
                <p class="text-center">{{ e }}</p>
            {% endfor %}
            </div>
            {% endif %}
            {% if status %}
            <div class="alert alert-success">
                <p class="text-center">{{ status }}</p>
            </div>
        {% endif %}
             </div>
        </div>
        <div style="text-align:center; margin-bottom:20px;">
                        <a href="https://jpack.info">トップへ戻る</a>
        </div>
        </div>
    </body>
</html>
