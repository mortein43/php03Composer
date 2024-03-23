<?php
echo "<a href='Index.php'>Index.php</a>";
if (file_exists('ticket.xml')) {
    $xml = simplexml_load_file('ticket.xml');
    echo "<br><br>";
    if ($xml !== false) {

        foreach ($xml->ticket as $ticket) {
            $date = (string) $ticket->date;
            echo "<p>" . date('d/m/Y', strtotime($date)) . "</p>" . PHP_EOL;

            foreach ($ticket->items->item as $item) {
                $name = (string) $item['name'];
                $count = (int) $item->count;
                $price = (int) $item->price;
                $total = (int) $item->total;

                echo "<p>$name: $price$; Count: $count; Total: $total$</p>";
            }

            $totalPrice = (int) $ticket->total;
            echo "<p><strong>Total Price: $totalPrice$</strong></p>" . PHP_EOL;
            echo PHP_EOL;
        }


    } else {
        echo "Failed to load XML file.";
    }
} else {
    echo "File ticket.xml not found.";
}
?>
