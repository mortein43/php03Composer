<?php
declare(strict_types = 1);

require_once "./vendor/autoload.php";

use OrgEizenheim\Composer\Product;

session_start();

if(!isset($_SESSION['items'])) {
    $_SESSION['items'] = [];
}

function addItem()
{
    $name = $_POST['name'] ?? '';
    $count = (int)$_POST['count'] ?? 0;
    $price = (int)$_POST['price'] ?? 0;

    $product = new Product($name, $count, $price);

    $_SESSION['items'][] = $product;
}

if (isset($_POST['addItem'])) {
    addItem();
}

if (isset($_POST['buy'])) {
    $file = 'ticket.xml';
    $tickets = null;
    if (file_exists($file)) {
        $tickets = simplexml_load_file($file);
    } else {
        $tickets = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><tickets></tickets>');
    }

    $ticket = $tickets->addChild('ticket');

    $ticket->addChild('date', date('Y-m-d H:i:s'));

    // Додавання елементів item
    $items = $ticket->addChild('items');
    foreach ($_SESSION['items'] as $item) {
        $itemElement = $items->addChild('item');
        $itemElement->addAttribute('name', $item->name);
        $itemElement->addChild('count', (string)$item->count);
        $itemElement->addChild('price', (string)$item->price);
        $itemElement->addChild('total', (string)($item->count * $item->price));
    }

    $totalPrice = array_sum(array_map(function ($item) {
        return $item->count * $item->price;
    }, $_SESSION['items']));
    $ticket->addChild('total', (string)$totalPrice);

    $tickets->asXML($file);

    $_SESSION['items'] = [];
}


echo "
<form method='post'>
    <label for='name'>Name</label>
    <input id='name' name='name' placeholder='Name' /><br>
    <label for='count'>Count</label>
    <input id='count' name='count' type='number' placeholder='Count' /><br>
    <label for='price'>Price</label>
    <input id='price' name='price' type='number' placeholder='Price' /><br>
    <button type='submit' name='addItem'>Add Item</button>
    <button type='submit' name='buy' >Buy</button>
    <button type='submit' name='getTickets' >Get Tickets</button>
</form>

";

if (isset($_POST['getTickets'])) {
    header("Location: tickets.php");
    exit;
}



