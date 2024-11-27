<h1>Garbage Collector Status</h1>

<h2>Initial Status</h2>
<pre><?php print_r($initialStatus); ?></pre>

<h2>Status After Query and Calculations</h2>
<pre><?php print_r($middleStatus); ?></pre>

<h2>Final Status After Garbage Collection</h2>
<pre><?php print_r($finalStatus); ?></pre>

<h2>Cycles Collected</h2>
<p><?= h($cyclesCollected); ?> cycles were collected.</p>
