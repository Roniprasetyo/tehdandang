# Design — Teh Dandang Sales Force Automation (SFA)

Locked design system. Future Hallmark runs read this file first; pages defer
to it. Amend intentionally — the file is the rule.

## System
- Genre · modern-minimal (enterprise FMCG distribution)
- Macrostructure · Master-Detail & Analytical Center
- Theme · catalog: Cobalt with Tea Accents (Deep Navy, Emerald, Tea Amber)
- Axes · clean-paper / roman-display / cobalt-emerald

## Tokens (canonical · `public/css/tokens.css` is the source of truth)
```css
:root {
  --color-paper:         #f8fafc;
  --color-paper-card:    #ffffff;
  --color-paper-muted:   #f1f5f9;
  --color-ink:           #0f172a;
  --color-ink-secondary: #334155;
  --color-ink-muted:     #64748b;
  --color-rule:          #e2e8f0;
  --color-rule-strong:   #cbd5e1;
  --color-accent:        #2563eb;
  --color-accent-hover:  #1d4ed8;
  --color-tea-emerald:   #059669;
  --color-tea-amber:     #d97706;
  --color-focus:         #3b82f6;

  --font-display: "Outfit", sans-serif;
  --font-body:    "Plus Jakarta Sans", sans-serif;
  --font-mono:    ui-monospace, monospace;

  --ease-tactile: cubic-bezier(0.16, 1, 0.3, 1);
  --dur-fast:     150ms;
  --dur-base:     220ms;

  --radius-card:  16px;
  --radius-btn:   12px;
  --radius-pill:  9999px;
}
```

## CTA voice
- Primary · Solid Accent (`var(--color-accent)`) · 12px radius · tactile click `translateY(1px)`
- Secondary · Hairline border (`var(--color-rule)`) on card paper · same radius · subtle hover lift
- Badges · Soft pill backgrounds with matching hairline border and rich saturated label ink

## Anti-AI-Slop Disciplines in Effect
1. Pre-emit self-critique: Score P5 H5 E5 S5 R5 V5 on each page.
2. Honest copy: No fake percentages, fabricated KPIs, or hollow superlatives.
3. Locked tokens: Always reference CSS variables or defined Tailwind classes.
4. No re-drawn fake browser or device mockups.
5. Strict mobile responsiveness (verified at 320px, 375px, 414px, 768px, 1024px, 1440px).
6. Typography purity: Headings are roman (`font-style: normal`), no italic headings. Tabular figures use `tabular-nums`.

## Exports
`public/css/tokens.css` is the source of truth for runtime CSS tokens.
