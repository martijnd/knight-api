<?php

use App\Models\Location;

it('calculates the distance between two coordinates', function () {
  $l1 = Location::factory()->create([
    'x' => 0,
    'y' => 0,
  ]);

  $l2 = Location::factory()->create([
    'x' => 10,
    'y' => 10,
  ]);

  expect($l1->distanceTo($l2))->toBe(14);

  $l2 = Location::factory()->create([
    'x' => 40,
    'y' => 70,
  ]);

  expect($l1->distanceTo($l2))->toBe(80);
});
