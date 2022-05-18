# Knight API
Knight API is a headless MMORPG API. This means that you have to build your own front-end for it!

## Data model

### User
username: string
base_strength: int
gold: int
health: int
max_health: int
weapon_id: int
ActiveWeapon: Weapon
weapons: Weapon[]
armor: Armor[]

### Enemy
name: string
health: int
damage: int

### Weapon
name: string
damage: int
users: User[]

## Armor
name: string
defense: int
users: User[]






### Shop
weapons: ShopWeapon[]
armor: ShopArmor[]

### ShopWeapon
price: int
weapon_id: int
Weapon: Weapon
shop_id: int
shop: Shop

### ShopArmor
price: int
armor_id: int
Armor: Armor
shop_id: int
shop: Shop
