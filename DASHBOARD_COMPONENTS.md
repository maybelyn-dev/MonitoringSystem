# Dashboard Component Reference & Design Tokens

## Color Palette

### Primary Colors
```
Deep Charcoal (Background)
HEX: #0a0e27
RGB: 10, 14, 39
Text: Primary dark backgrounds
Usage: Page backgrounds, card backgrounds

Electric Blue Neon (Primary Accent)
HEX: #00ffdd
RGB: 0, 255, 221
Text: Glowing neon accents
Usage: Borders, highlights, primary UI elements

Cyan Accent (Secondary)
HEX: #00d4ff
RGB: 0, 212, 255
Text: Light blue interactive elements
Usage: Hover states, secondary highlights

White (Text Primary)
HEX: #ffffff
RGB: 255, 255, 255
Text: Main text, headers
Usage: Primary typography

Steel Gray (Text Secondary)
HEX: #9ca3af
RGB: 156, 163, 175
Text: Secondary text, labels
Usage: Secondary typography, disabled states

Charcoal Dark (Secondary BG)
HEX: #1a1f3a
RGB: 26, 31, 58
Text: Secondary backgrounds
Usage: Alternative backgrounds, dark overlays
```

### Status Colors
```
Success (Green)
HEX: #10b981
Usage: Active, Completed, Approved

In Progress (Neon Blue)
HEX: #00ffdd or #3b82f6
Usage: Active processes, In Progress

Pending (Amber)
HEX: #f59e0b
Usage: Awaiting action, Pending review

Error (Red)
HEX: #ef4444
Usage: Errors, On Hold, Failed states
```

---

## Typography

### Font Family
```
Primary: Instrument Sans
Fallback: ui-sans-serif, system-ui, sans-serif
Apple Color Emoji, Segoe UI Emoji, Noto Color Emoji
```

### Font Sizes & Weights
```
H1 (Page Title)
Font Size: 36px (text-4xl)
Font Weight: 700 (bold)
Line Height: 1.1

H2 (Section Title)
Font Size: 20px (text-xl)
Font Weight: 700 (bold)
Line Height: 1.2

H3 (Card Title)
Font Size: 18px (text-lg)
Font Weight: 600 (semibold)
Line Height: 1.2

Body Text
Font Size: 16px (base)
Font Weight: 400 (regular)
Line Height: 1.5

Small Text
Font Size: 14px (text-sm)
Font Weight: 400 (regular)
Line Height: 1.5

Extra Small
Font Size: 12px (text-xs)
Font Weight: 600 (semibold)
Line Height: 1.4
```

---

## Spacing

### Consistent Spacing Scale
```
xs: 2px (0.125rem)
sm: 4px (0.25rem)
base: 8px (0.5rem)
md: 12px (0.75rem)
lg: 16px (1rem)
xl: 24px (1.5rem)
2xl: 32px (2rem)
3xl: 48px (3rem)
```

### Common Usage
```
Padding:
  Small Cards: p-6 (24px)
  Large Cards: p-8 (32px)
  Buttons: px-4 py-2 (16px × 8px)

Margin:
  Section Gap: mb-12 (48px)
  Card Gap: gap-6 (24px)
  Text Spacing: mb-4 (16px)
```

---

## Components

### Component: KPI Card
```html
<div class="glass-card group hover-glow cursor-pointer">
  <div class="absolute inset-0 bg-gradient-to-br from-neon-blue/10 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
  <div class="relative">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-sm font-semibold text-gray-300">Metric Name</h3>
      <div class="w-10 h-10 rounded-lg bg-neon-blue/10 flex items-center justify-center text-neon-blue">
        <!-- Icon -->
      </div>
    </div>
    <div class="mb-2">
      <p class="text-3xl font-bold text-white">123</p>
      <p class="text-xs text-neon-blue mt-1">+5% growth</p>
    </div>
    <div class="h-1 bg-charcoal-800 rounded-full overflow-hidden">
      <div class="h-full w-4/5 bg-gradient-to-r from-neon-blue to-cyan-500 rounded-full animate-pulse"></div>
    </div>
  </div>
</div>
```

**Classes:**
- `.glass-card`: Base glassmorphic styling
- `.group`: Group hover effects
- `.hover-glow`: Neon glow on hover
- `from-neon-blue/10`: 10% opacity neon blue gradient

**Features:**
- Icon container with neon background
- Large metric display
- Stat description with color accent
- Progress bar with gradient
- Pulse animation

---

### Component: Glass Card
```html
<div class="glass-card glass-card-lg hover-glow">
  <!-- Content -->
</div>
```

**Variants:**
```
.glass-card          - Base card (p-6 padding)
.glass-card-lg       - Large card (p-8 padding)
.glass-card-lg hover-glow - Large card with glow effect
```

**Styling:**
```css
- Border Radius: 16px (rounded-2xl)
- Border: 1px white/10
- Background: rgba(255,255,255,0.05) with blur
- Box Shadow: 0 8px 32px rgba(31,38,135,0.1)
- Backdrop Blur: 16px
- Transition: 0.3s all ease
```

---

### Component: Progress Bar
```html
<div class="h-1 bg-charcoal-800 rounded-full overflow-hidden">
  <div class="h-full w-4/5 bg-gradient-to-r from-neon-blue to-cyan-500 rounded-full animate-pulse"></div>
</div>
```

**Variants:**
```
w-1/4  - 25% complete
w-1/3  - 33% complete
w-1/2  - 50% complete
w-2/3  - 66% complete
w-3/4  - 75% complete
w-4/5  - 80% complete
w-full - 100% complete
```

---

### Component: Status Badge
```html
<!-- Active -->
<span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-400 border border-green-500/30">Active</span>

<!-- In Progress -->
<span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/20 text-blue-400 border border-blue-500/30">In Progress</span>

<!-- Pending -->
<span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">Pending</span>

<!-- Completed -->
<span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-400 border border-green-500/30">Completed</span>
```

---

### Component: Metric Row
```html
<div class="flex items-center justify-between p-3 rounded-lg bg-neon-blue/5 border border-neon-blue/20 hover:border-neon-blue/50 transition-colors">
  <span class="text-sm text-gray-300">Label</span>
  <span class="text-lg font-bold text-neon-blue">Value</span>
</div>
```

**Features:**
- Left-aligned label
- Right-aligned value in neon blue
- Subtle background with neon border
- Hover border enhancement
- Smooth color transitions

---

### Component: Data Table Row
```html
<tr class="border-b border-charcoal-800 hover:bg-neon-blue/5 transition-colors">
  <td class="px-6 py-4 text-sm text-gray-300">Cell 1</td>
  <td class="px-6 py-4 text-sm text-white font-medium">Cell 2</td>
  <td class="px-6 py-4"><span class="badge-active">Active</span></td>
</tr>
```

---

### Component: Button
```html
<!-- Primary CTA Button -->
<button class="px-6 py-3 rounded-lg bg-gradient-to-r from-neon-blue to-cyan-500 text-charcoal-950 font-semibold hover:shadow-lg hover:shadow-neon-blue/50 transition-all hover:-translate-y-0.5">
  Export Report
</button>

<!-- Secondary Card Button -->
<button class="px-4 py-2 rounded-lg bg-charcoal-800 text-white border border-neon-blue/30 hover:border-neon-blue/60 transition-all">
  Action
</button>
```

---

## Animations

### Keyframe: fadeIn
```css
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(8px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
Duration: 0.6s
Easing: ease
```

### Keyframe: slideIn
```css
@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateX(-20px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}
Duration: 0.6s
Easing: ease-out
```

### Keyframe: glowPulse
```css
@keyframes glowPulse {
  0%, 100% {
    box-shadow: 
      0 0 20px rgba(0, 255, 221, 0.5),
      0 0 40px rgba(0, 255, 221, 0.3);
  }
  50% {
    box-shadow: 
      0 0 30px rgba(0, 255, 221, 0.8),
      0 0 60px rgba(0, 255, 221, 0.5);
  }
}
Duration: 3s
Easing: ease-in-out
Iteration: infinite
```

### Keyframe: shimmer
```css
@keyframes shimmer {
  0% { background-position: -1000px 0; }
  100% { background-position: 1000px 0; }
}
Duration: 2s
Iteration: infinite
```

---

## Utility Classes

### Backdrop Effect
```css
.backdrop-blur-xl {
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
}
```

### Text Effects
```css
.text-glow {
  text-shadow: 
    0 0 10px rgba(0, 255, 221, 0.5),
    0 0 20px rgba(0, 255, 221, 0.3);
}
```

### Gradient Text
```html
<h1 class="bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
  Gradient Text
</h1>
```

---

## Responsive Breakpoints

```
Mobile:     < 640px   (single column)
Tablet:     640px-1024px   (2 columns)
Desktop:    > 1024px   (4+ columns)
```

### Grid Utilities
```
.grid-cols-1         - Single column (mobile)
.md:grid-cols-2      - 2 columns (tablet)
.lg:grid-cols-4      - 4 columns (desktop)
```

---

## Chart.js Customization

### Line Chart
```javascript
{
  borderColor: '#00ffdd',
  backgroundColor: gradient,
  borderWidth: 3,
  tension: 0.4,
  fill: true,
  pointRadius: 5,
  pointBackgroundColor: '#00ffdd',
}
```

### Bar Chart
```javascript
{
  borderRadius: 8,
  borderSkipped: false,
  backgroundColor: 'rgba(0, 255, 221, 0.8)',
  borderColor: '#00ffdd',
  borderWidth: 2,
}
```

### Donut Chart
```javascript
{
  cutout: '70%',
  backgroundColor: ['#10b981', '#00ffdd', '#f59e0b'],
  borderColor: '#0a0e27',
  borderWidth: 3,
}
```

---

## Shadows & Glows

### Box Shadows
```css
/* Subtle Shadow */
box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);

/* Neon Glow */
box-shadow: 
  0 0 20px rgba(0, 255, 221, 0.3),
  0 0 40px rgba(0, 255, 221, 0.1),
  0 8px 32px 0 rgba(0, 150, 200, 0.2);

/* Intense Glow */
box-shadow: 0 0 30px rgba(0, 255, 221, 0.8),
  0 0 60px rgba(0, 255, 221, 0.5);
```

---

## Grid Layout System

### Section Spacing
```css
.max-w-7xl       - Content max width (80rem/1280px)
.mx-auto         - Center horizontally
.px-6 md:px-8    - Horizontal padding
.py-12           - Vertical padding (48px)
.gap-6           - Element gap (24px)
```

### Responsive Grid
```css
/* KPI Cards */
grid-cols-1           /* Mobile: 1 column */
md:grid-cols-2        /* Tablet: 2 columns */
lg:grid-cols-4        /* Desktop: 4 columns */

/* Chart Section */
lg:grid-cols-2        /* Desktop: 2 columns side by side */
```

---

## Accessibility

### Focus States
```css
:focus {
  outline: 2px solid #00ffdd;
  outline-offset: 2px;
}
```

### High Contrast Mode
```css
@media (prefers-contrast: more) {
  .glass-card {
    border-color: #00ffdd;
  }
}
```

### Reduced Motion
```css
@media (prefers-reduced-motion: reduce) {
  * {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
}
```

---

## Performance Metrics

### Recommended Sizes
```
CSS File: ~45KB (minified)
JS Bundle: ~85KB (minified)
Chart.js CDN: ~65KB
Total: ~195KB (gzipped: ~55KB)

Lighthouse Targets:
- Performance: 90+
- Accessibility: 95+
- Best Practices: 90+
- SEO: 95+
```

---

**Design Tokens Version:** 1.0.0
**Last Updated:** March 2026
**Status:** Finalized ✅
