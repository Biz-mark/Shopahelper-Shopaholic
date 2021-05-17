# Shopahelper plugin for Shopaholic

Shopahelper is a basic bulk tool that helps you to manage your catalog.

### Caching:
- `shopahelper:cache.all {chunk}` - Cache all Products, Brands, Categories, Offers by chunks with N items.
- `shopahelper:cache.products {chunk}` - Cache Products by chunks with N products. 
- `shopahelper:cache.brands {chunk}` - Cache Brands by chunks with N brands.
- `shopahelper:cache.categories {chunk}` - Cache Categories by chunks with N categories.
- `shopahelper:cache.offers {chunk}` - Cache Offers by chunks with N offers.

### Generators
- `shopahelper:generate.offers` - Generating offers for each product that doesn't have it.

### Linkers

- `{products}` - In that variable you can pass a single ID or Multiple ID's separated by commas. Example: `shopahelper:link.brand-to-products 1 13,14,15` - Link Brand with id 1 to Products with id 13,14 and 15.


- Brands
    - `shopahelper:link.brand-to-products {brand_id} {products}` - Link Brand by id to products by id's separated by comma. 
    - `shopahelper:link.brand-to-products-by-category {brand_id} {category_id}` - Link Brand by ID to products inside Category by ID
- Category
    - `shopahelper:link.category-to-products {category_id} {products}` - Link Category by ID to Products by ID's separated by comma
    - `shopahelper:link.category-to-products-by-category {old_category_id} {new_category_id}` - Link main Category ID to Products by their main Category ID;
- Additional Category
    - `shopahelper:link.add-categories-to-products {category_id} {products}` - Link Additional Category by ID to Products by ID's separated by comma
        - `shopahelper:link.add-category-to-products-by-add-category {target_category_id} {current_category_id}` - Link Additional Category by ID to Products that has additional category by ID
    - `shopahelper:link.add-category-to-products-by-category {target_category_id} {current_category_id}` - Link Additional Category by ID to Products that has main Category by ID

### Detachers

- `{products}` - In that variable you can pass a single ID or Multiple ID's separated by commas.

- `shopahelper:detach.add-category-from-products {category} {products}` - Detaches Additional Category from Products by ID's separated by comma

### Prices

- `{products}` - In that variable you can pass a single ID or Multiple ID's separated by commas. Example: `shopahelper:price.upscale-by-percentage 10 13,14,15` - Upscale offers price by 10% in Products with id's 13,14,15
- `{category_tree}` - Boolean variable that accepts `true` or `false` strings. If passed `true` - proceeds action to all subcategories of target category.


- Upscale
    - `shopahelper:price.upscale-by-percentage {percentage} {products}` - Upscale price by N percentage to Offers of Products by ID's separated by comma
    - `shopahelper:price.upscale-by-percentage-by-brand {percentage} {brand_id}` - Upscale price by N percentage to Offers of Products of Brand by ID
    - `shopahelper:price.upscale-by-percentage-by-category {percentage} {category_id} {category_tree}` - Upscale price by N percentage to Offers of Products of Category by ID.
    - `shopahelper:price.upscale-by-percentage-custom` - Upscale price by N percentage to Offers of Products by ID's separated by comma with custom condition that you can specify in code.
- Downscale
  - `shopahelper:price.downscale-by-percentage` - Downscale price by N percentage to Offers of Products by ID's separated by comma.
  - `shopahelper:price.downscale-by-percentage-by-brand` - Downscale price by N percentage to Offers of Products of Brand by ID
  - `shopahelper:price.downscale-by-percentage-by-category` - Downscale price by N percentage to Offers of Products of Category by ID. 
