# GiveMapper
PocketMine-MP plugin which adds a whole bunch of quality-of-life aliases for blocks to /give

## What?
If you're tired of magic data values in `/give`, this plugin is for you.

Examples:
- `stone:5` -> `andesite`
- `log:2` -> `birch_log`
- `cobblestone_wall:6` -> `brick_wall`

You can check the `resources/fake_ids.json` file for a full list of available aliases.
These aliases are mostly similar to the MC:Java IDs, although they aren't expected to be 1:1 identical.

## How?
These mappings were generated from block display names in PocketMine-MP.

## Usage
Load the plugin and have fun with your new `/give` aliases. No additional configuration required.
