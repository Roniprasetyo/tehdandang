# Design — PT. Kartini Teh Dandang SFA

Locked design system. Future Hallmark runs read this file first; pages defer
to it. Amend intentionally — the file is the rule.

## System
- Genre · modern-minimal (enterprise FMCG distribution)
- Typography · Poppins (all headings roman upright, sans-serif body) + JetBrains Mono (financial & telemetry tabular numbers)
- Icons · Material Design Icons (MDI)
- Macrostructure · Master-Detail & Analytical Center
- Theme · Tri-Tone Heritage (Tea Forest Green, Amber Brew, Sky Telemetry Blue)

## 3 Kombinasi Warna Utama (Primer, Sekunder, Aksen)
```css
:root {
  /* 1. Warna Primer: Deep Forest Tea Green (Identity daun teh Dandang) */
  --color-primary:        #15803d;
  --color-primary-hover:  #166534;
  --color-primary-light:  #f0fdf4;
  --color-primary-border: #bbf7d0;

  /* 2. Warna Sekunder: Warm Amber Brew (Seduhan teh kental harum) */
  --color-secondary:        #b45309;
  --color-secondary-hover:  #92400e;
  --color-secondary-light:  #fffbeb;
  --color-secondary-border: #fde68a;

  /* 3. Warna Aksen: Sky Telemetry Blue (Data telemetry, GPS tracking, and sync badges) */
  --color-accent:        #0284c7;
  --color-accent-hover:  #0369a1;
  --color-accent-light:  #f0f9ff;
  --color-accent-border: #bae6fd;

  /* Neutral Paper & Ink */
  --color-paper:         #f8fafc;
  --color-paper-card:    #ffffff;
  --color-ink:           #0f172a;
  --color-ink-secondary: #334155;
  --color-ink-muted:     #64748b;
  --color-rule:          #e2e8f0;
  --color-rule-strong:   #cbd5e1;

  /* Typography Stacks */
  --font-display: "Poppins", sans-serif;
  --font-body:    "Poppins", sans-serif;
  --font-mono:    "JetBrains Mono", monospace;

  /* Microinteractions */
  --ease-tactile: cubic-bezier(0.16, 1, 0.3, 1);
  --dur-fast:     150ms;
  --dur-base:     220ms;

  --radius-card:  16px;
  --radius-btn:   12px;
  --radius-pill:  9999px;
}
```

## Anti-Vibe-Coding Disciplines (Production Quality Guardrails)
1. **No Fake / Mock Slop**: Never use `rand()` in blade views for UI records. Datasets must follow genuine FMCG schema (SAP OCRD, OITM, RO, ROA, Concox GPS telemetry).
2. **No Intrusive Browser `alert()`**: Actions and exports use responsive in-app toast notifications (`window.notify(msg, type)`).
3. **Typography Rigor**: Font is strictly **Poppins** throughout; headings are roman (`font-style: normal`, no italic headers). Financial and analytical figures use `tabular-nums font-mono`.
4. **Icons**: Material Design Icons (MDI) via `<i class="mdi mdi-..."></i>`.
5. **Mobile Responsiveness**: Verified down to 320px with zero horizontal scroll (`overflow-x: clip`).
