<?php
// Enable Garbage Collector
gc_enable();

// Display the initial state of the Garbage Collector
echo "Initial Garbage Collector status:\n";
$initialStatus = gc_status();
debug($initialStatus);

// Create circular references
echo "\nCreating circular references...\n";
$a = new stdClass();
$a->b = new stdClass();
$a->b->a = $a;

// Display the state after creating circular references
echo "Status after creating circular references:\n";
$middleStatus = gc_status();
debug($middleStatus);

// Unset references to allow garbage collection
echo "\nReleasing references...\n";
unset($a);

// Force garbage collection
echo "Forcing garbage collection...\n";
gc_collect_cycles();

// Display the final state of the Garbage Collector
echo "Final Garbage Collector status:\n";
$finalStatus = gc_status();
debug($finalStatus);

?>

<h3>Expected Output (Varies by Environment):</h3>
<ol>
    <li><strong>Initial Status</strong>: Shows the Garbage Collector's state before any significant memory operations.</li>
    <li><strong>Status After Circular References</strong>: Highlights changes, such as an increase in <code>roots</code>, representing potential memory cycles.</li>
    <li><strong>Final Status</strong>: Displays increments in <code>collected</code> and <code>runs</code>, indicating the cleanup of memory cycles.</li>
</ol>
<h3>Explanation:</h3>
<ol>
    <li><strong>Initial Check</strong>: Establishes a baseline for memory usage and Garbage Collector activity.</li>
    <li><strong>Memory Stress</strong>: Circular references simulate complex memory structures, adding to the root buffer.</li>
    <li><strong>Cleanup</strong>: Explicitly releases memory (<code>unset</code>) and forces garbage collection with <code>gc_collect_cycles()</code>.</li>
</ol>
<h3>Use Cases:</h3>
<ul>
    <li><strong>Debugging Memory Leaks</strong>: Identify lingering memory cycles.</li>
    <li><strong>Performance Monitoring</strong>: Analyze memory management efficiency in real-time applications.</li>
    <li><strong>Optimization</strong>: Use insights to adjust application design or PHP configurations.</li>
</ul>

