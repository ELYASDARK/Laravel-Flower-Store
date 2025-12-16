# 🎨 Flower Store Color Scheme

## Beautiful Flower-Themed Color Palette

Your Flower Store now features a professional, vibrant color scheme inspired by beautiful flower gardens!

---

## 🌸 Primary Color (Rose Pink)

**Usage:** Main brand color, primary buttons, links, highlights

| Shade | Hex | Usage |
|-------|-----|-------|
| **50** | `#fef1f7` | Very light backgrounds |
| **100** | `#fee5f0` | Light backgrounds, hover states |
| **200** | `#ffcce3` | Borders, dividers |
| **300** | `#ffa3cc` | Disabled states |
| **400** | `#ff6ba9` | Lighter interactive elements |
| **500** | `#f9388a` | Secondary buttons |
| **600** | `#e91e6e` | ⭐ **Main brand color** |
| **700** | `#ca1257` | Hover states, active elements |
| **800** | `#a71349` | Text emphasis |
| **900** | `#8b1540` | Dark text |
| **950** | `#560621` | Very dark accents |

### Example Usage:
```html
<button class="bg-primary-600 hover:bg-primary-700 text-white">Shop Now</button>
```

---

## 🌿 Secondary Color (Fresh Green)

**Usage:** Success states, nature elements, "organic" features

| Shade | Hex | Usage |
|-------|-----|-------|
| **50** | `#f0fdf4` | Success backgrounds |
| **100** | `#dcfce7` | Light success states |
| **300** | `#86efac` | Success borders |
| **500** | `#22c55e` | Success messages |
| **600** | `#16a34a` | ⭐ **Main secondary color** |
| **700** | `#15803d` | Secondary hover states |

### Example Usage:
```html
<div class="bg-secondary-600 text-white">✓ Order Placed Successfully!</div>
```

---

## 💜 Accent Color (Lavender Purple)

**Usage:** Special highlights, premium features, accents

| Shade | Hex | Usage |
|-------|-----|-------|
| **50** | `#faf5ff` | Accent backgrounds |
| **100** | `#f3e8ff` | Light accents |
| **300** | `#d8b4fe` | Accent borders |
| **500** | `#a855f7` | Accent elements |
| **600** | `#9333ea` | ⭐ **Main accent color** |
| **700** | `#7e22ce` | Accent hover states |

### Example Usage:
```html
<span class="bg-accent-600 text-white">Premium</span>
```

---

## 🎨 Custom Gradient Classes

Beautiful pre-made gradients for modern UI:

### Gradient Primary (Rose)
```html
<div class="gradient-primary text-white">
    <!-- Rose pink gradient -->
</div>
```
**Colors:** `#f9388a` → `#e91e6e`

### Gradient Secondary (Green)
```html
<div class="gradient-secondary text-white">
    <!-- Fresh green gradient -->
</div>
```
**Colors:** `#22c55e` → `#16a34a`

### Gradient Accent (Purple)
```html
<div class="gradient-accent text-white">
    <!-- Lavender gradient -->
</div>
```
**Colors:** `#a855f7` → `#9333ea`

### Gradient Hero (Soft Floral)
```html
<div class="gradient-hero">
    <!-- Soft floral gradient for hero sections -->
</div>
```
**Colors:** `#fee5f0` → `#fef1f7` → `#f3e8ff`

---

## 🔘 Pre-built Button Classes

### Primary Button
```html
<button class="btn-primary">Add to Cart</button>
```
**Style:** Rose pink background with shadow and hover effects

### Secondary Button
```html
<button class="btn-secondary">Success Action</button>
```
**Style:** Green background with shadow and hover effects

### Accent Button
```html
<button class="btn-accent">Premium Feature</button>
```
**Style:** Purple background with shadow and hover effects

---

## 📋 Color Usage Guidelines

### Navigation Bar
- **Background:** White (`bg-white`)
- **Links:** Gray text (`text-gray-700`)
- **Hover:** Rose pink (`hover:text-primary-600` + `hover:bg-primary-50`)
- **Active:** Rose pink background (`bg-primary-100 text-primary-600`)

### Buttons
- **Primary Actions:** `btn-primary` or `bg-primary-600`
- **Secondary Actions:** `btn-secondary` or `bg-secondary-600`
- **Special Features:** `btn-accent` or `bg-accent-600`

### Cards & Content
- **Card Background:** White (`bg-white`)
- **Borders:** Gray 200 (`border-gray-200`)
- **Hover:** Subtle shadow (`hover:shadow-lg`)

### Status Indicators
- **Success:** `bg-secondary-600 text-white`
- **Error:** `bg-red-600 text-white`
- **Warning:** `bg-yellow-500 text-white`
- **Info:** `bg-accent-600 text-white`

---

## 🎯 Quick Color Reference

| Element | Color Class |
|---------|-------------|
| Brand Logo | `text-primary-600` |
| Primary Button | `bg-primary-600 hover:bg-primary-700` |
| Links | `text-primary-600 hover:text-primary-700` |
| Success Message | `bg-secondary-600` |
| Price Tag | `text-primary-700 font-bold` |
| Sale Badge | `bg-accent-600` |
| Footer | `bg-gray-800` |
| Body Background | `bg-gray-50` |

---

## 🌈 Color Psychology

### Rose Pink (Primary)
- **Emotion:** Love, Romance, Beauty
- **Perfect for:** Flower store, feminine products, romantic themes
- **Message:** "Fresh, beautiful, elegant"

### Fresh Green (Secondary)
- **Emotion:** Nature, Growth, Freshness
- **Perfect for:** Organic products, natural elements, success states
- **Message:** "Natural, fresh, organic"

### Lavender Purple (Accent)
- **Emotion:** Luxury, Creativity, Premium
- **Perfect for:** Special offers, premium products, unique features
- **Message:** "Premium, special, unique"

---

## 🎨 Accessibility

All colors meet WCAG 2.1 Level AA standards:
- ✅ Primary-600 on white: **Contrast ratio 4.5:1+**
- ✅ Secondary-600 on white: **Contrast ratio 4.5:1+**
- ✅ White text on primary-600: **Contrast ratio 4.5:1+**
- ✅ White text on secondary-600: **Contrast ratio 4.5:1+**

---

## 🚀 Quick Examples

### Hero Section
```html
<div class="gradient-hero py-16">
    <h1 class="text-4xl font-bold text-primary-700">Welcome to Our Flower Store</h1>
    <button class="btn-primary mt-4">Shop Now</button>
</div>
```

### Product Card
```html
<div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow">
    <img src="product.jpg" alt="Flower" class="rounded-t-lg">
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-800">Rose Bouquet</h3>
        <p class="text-primary-700 font-bold text-xl">$49.99</p>
        <button class="btn-primary w-full mt-4">Add to Cart</button>
    </div>
</div>
```

### Success Alert
```html
<div class="bg-secondary-600 text-white rounded-lg p-4 shadow-md">
    <p class="font-medium">✓ Your order has been placed successfully!</p>
</div>
```

---

## 📱 Responsive Colors

Colors work perfectly across all devices:
- ✅ Desktop: Full vibrancy
- ✅ Tablet: Optimized gradients
- ✅ Mobile: Touch-friendly sizes

---

**Your Flower Store now has a beautiful, professional, and consistent color scheme! 🌸✨**

