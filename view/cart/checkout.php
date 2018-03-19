<?php
namespace Anax\View;


$url = url("product");
$counter = 0;
$price = 0;
$amountOfItems = 0;
$totalWeight = 0;
$totalShipping = 0;

$order = url("cart/order");
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75">
        <h1 class="text-center">Kassa</h1>
        <table class="table border mb-4">
            <thead>
                <tr>
                    <th scope="col" class="border-bottom-0">Tillverkare</th>
                    <th scope="col" class="border-bottom-0">Namn</th>
                    <th scope="col" class="border-bottom-0">Storlek</th>
                    <th scope="col" class="border-bottom-0">Pris</th>
                    <th scope="col" class="border-bottom-0">Färg</th>
                    <th scope="col" class="border-bottom-0">Antal</th>
                    <th scope="col" class="border-bottom-0"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ((array)$cartItems as $key => $value) : ?>
                    <?php if ($counter % 2) : ?>
                        <tr class="bg-light">
                            <td><?= $value["productManufacturer"] ?></td>
                            <td><?= $value["productName"] ?></td>
                            <td><?= $value["productSize"] ?></td>
                            <td><?= $value["productSellPrize"] ?></td>
                            <td><?= $value["productColor"] ?></td>
                            <td><?= $value['amount'] ?></td>
                            <th scope="row"><a href="<?= $url ?>/<?= $value['productID'] ?>">Mer information</a></th>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td><?= $value["productManufacturer"] ?></td>
                            <td><?= $value["productName"] ?></td>
                            <td><?= $value["productSize"] ?></td>
                            <td><?= $value["productSellPrize"] ?></td>
                            <td><?= $value["productColor"] ?></td>
                            <td><?= $value['amount'] ?></td>
                            <th scope="row"><a href="<?= $url ?>/<?= $value['productID'] ?>">Mer information</a></th>
                        </tr>
                    <?php endif; ?>
                    <?php
                    $price += ((int)$value['productSellPrize'] * (int)$value['amount']);
                    $totalWeight += (int)$value['productWeight'] * (int)$value['amount'];
                    $amountOfItems += ((int)$value['amount']);
                    $totalShipping = ($totalWeight / 1000) < 1 ? 50 : 50 + (20 * round($totalWeight / 1000));
                    $counter++;
                    ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if ($amountOfItems > 0) : ?>
            <table class="table w-25 border border-top-0">
                <thead>
                    <tr class="text-center font-weight-bold">
                        <th colspan="2">Beställningsinformation</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Antal Produkter:</th>
                        <td><?= $amountOfItems ?></td>
                    </tr>
                    <tr>
                        <th>Total vikt:</th>
                        <td><?= round($totalWeight / 1000, 1) ?> kg</td>
                    </tr>
                    <tr>
                        <th>Summa:</th>
                        <td><?= $price ?> kr</td>
                    </tr>
                    <tr>
                        <th>Frakt:</th>
                        <td><?= $totalShipping ?> kr</td>
                    </tr>
                    <tr>
                        <th>Summa totalt:</th>
                        <td><?= $price + $totalShipping ?> kr</td>
                    </tr>
                </tbody>
            </table>
            <a href="<?= $order ?>"><button type="button" class="btn btn-primary w-10">Beställ</button></a>
        <?php elseif ($amountOfItems < 1) : ?>
            <p>Din kundvagn innehåller för tillfället inga produkter.</p>
        <?php endif; ?>
    </div>
</div>