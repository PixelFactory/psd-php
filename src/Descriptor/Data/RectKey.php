<?php


namespace Psd\Descriptor\Data;

/**
 * This $have rect keys.
 * Space after 'Top' need because keys have 4 chars.
 * Data for real file:
 *   'Top ': 0,
 *   Left: 0,
 *   Btom: 10,
 *   Rght: 10
 */
interface RectKey {
  const LEFT = 'Left';
  const TOP = 'Top ';
  const RIGHT = 'Rght';
  const BOTTOM = 'Btom';
};
