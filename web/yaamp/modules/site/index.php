<?php

$algo = user()->getState('yaamp-algo');

JavascriptFile("/extensions/jqplot/jquery.jqplot.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.dateAxisRenderer.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.barRenderer.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.highlighter.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.cursor.js");
JavascriptFile('/yaamp/ui/js/auto_refresh.js');

$height = '240px';

$min_payout = floatval(YAAMP_PAYMENTS_MINI);
$min_sunday = $min_payout/10;

$payout_freq = (YAAMP_PAYMENTS_FREQ / 3600)." hours";
?>

<div id='resume_update_button' style='color: #444; background-color: #ffd; border: 1px solid #eea;
        padding: 10px; margin-left: 20px; margin-right: 20px; margin-top: 15px; cursor: pointer; display: none;'
        onclick='auto_page_resume();' align=center>
        <b>Auto refresh is paused - Click to resume</b></div>

<table cellspacing=20 width=100%>
<tr><td valign=top width=50%>

<!--  -->

<div class="main-left-box">
<div class="main-left-title">HyperspacePool</div>
<div class="main-left-inner">
  <p>We are a community-supported mining pool for <a href="https://hspace.app">Hyperspace</a>.</p>
  <p>
    -  <strong>Get paid what you deserve </strong> - Blocks are distributed using PROP with a 0% fee.<br>
    -  <strong>ASIC support </strong> - All blake2b miners are supported. Use your Obelisk SC1s, Antminer A3s, S11/B52s, and more!<br>
    -  <strong>Quick payouts </strong> - Payments are made every <?= $payout_freq ?> for all balances above <b><?= $min_payout ?></b> SPACE, or <b><?= $min_sunday ?></b> SPACE on Sundays.<br>
    -  <strong>No registration </strong> - Use your wallet address as your username for easy payouts.<br>
    -  <strong>No hidden fees </strong> - All payouts are free of charge.<br>
    </p>
</ul>
</div></div>
<br/>

<!--  -->

<div class="main-left-box">
<div class="main-left-title">STRATUM SERVERS</div>
<div class="main-left-inner">

<ul>

<li>
<b>US: </b><br/>
<p class="main-left-box" style='padding: 3px; font-size: .8em; background-color: #ffffee; font-family: monospace;'>
stratum+tcp://us.hyperspacepool.com:3333
</p>
</li>

<li>
<b>EU: </b><br/>
<p class="main-left-box" style='padding: 3px; font-size: .8em; background-color: #ffffee; font-family: monospace;'>
A european server will go live before the Hyperspace network launch!
</p>
</li>


<li>Make sure you specify a valid wallet address as your username. </li>
<li>Passwords are not used by the server and can be empty or something arbitrary.</li>

<br>

</ul>
</div></div><br>

<!--  -->

<div class="main-left-box">
<div class="main-left-title">LINKS</div>
<div class="main-left-inner">

<ul>

<!--<li><b>BitcoinTalk</b> - <a href='https://bitcointalk.org/index.php?topic=508786.0' target=_blank >https://bitcointalk.org/index.php?topic=508786.0</a></li>-->
<!--<li><b>IRC</b> - <a href='http://webchat.freenode.net/?channels=#yiimp' target=_blank >http://webchat.freenode.net/?channels=#yiimp</a></li>-->

<li><b>API</b> - <a href='/site/api'>http://<?= YAAMP_SITE_URL ?>/site/api</a></li>
<li><b>Difficulty</b> - <a href='/site/diff'>http://<?= YAAMP_SITE_URL ?>/site/diff</a></li>
<?php if (YIIMP_PUBLIC_BENCHMARK): ?>
<li><b>Benchmarks</b> - <a href='/site/benchmarks'>http://<?= YAAMP_SITE_URL ?>/site/benchmarks</a></li>
<?php endif; ?>

<?php if (YAAMP_ALLOW_EXCHANGE): ?>
<li><b>Algo Switching</b> - <a href='/site/multialgo'>http://<?= YAAMP_SITE_URL ?>/site/multialgo</a></li>
<?php endif; ?>

<br>

</ul>
</div></div><br>

<!--
<a class="twitter-timeline" href="https://twitter.com/hashtag/YAAMP" data-widget-id="617405893039292417" data-chrome="transparent" height="450px" data-tweet-limit="3" data-aria-polite="polite">Tweets about #YAAMP</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

-->
</td><td valign=top>


<div id='pool_current_results'>
<br><br><br><br><br><br><br><br><br><br>
</div>

<div id='pool_history_results'>
<br><br><br><br><br><br><br><br><br><br>
</div>

</td></tr></table>

<br><br><br><br><br><br><br><br><br><br>

<script>

function page_refresh()
{
        pool_current_refresh();
        pool_history_refresh();
}

function select_algo(algo)
{
        window.location.href = '/site/algo?algo='+algo+'&r=/';
}

////////////////////////////////////////////////////

function pool_current_ready(data)
{
        $('#pool_current_results').html(data);
}

function pool_current_refresh()
{
        var url = "/site/current_results";
        $.get(url, '', pool_current_ready);
}

////////////////////////////////////////////////////

function pool_history_ready(data)
{
        $('#pool_history_results').html(data);
}

function pool_history_refresh()
{
        var url = "/site/history_results";
        $.get(url, '', pool_history_ready);
}

</script>
