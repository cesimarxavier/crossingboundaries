# Crossing Boundaries | Durham University & UFRJ

![Project Status](https://img.shields.io/badge/Status-Prototype%20Complete-success)
![HTML5](https://img.shields.io/badge/HTML5-Semantic-orange)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-CDN-38B2AC)
![Accessibility](https://img.shields.io/badge/A11y-WCAG_2.1-blue)

> **Interdisciplinary intercultural learning for sustainable development through COIL.**

This repository contains the front-end source code for the **Crossing Boundaries** project website. This initiative investigates how students and researchers from **Durham University (UK)** and **UFRJ (Brazil)** explore themes related to the UN Sustainable Development Goals (SDGs) through chemistry, education, and intercultural dialogue.

---

## 📸 Screenshots

<div align="center">
  <img src="./assets/home-preview.png" alt="Home Page Desktop" width="800" />
</div>

---

## 🎯 Project Overview

The website serves as a showcase and dissemination hub for the COIL (Collaborative Online International Learning) project.

**Key Objectives:**
1.  **Showcase Solutions:** Highlight student-led projects (e.g., biodegradable nanopesticides, probiotics) addressing real-world SDGs.
2.  **Explain Methodology:** Visualise the 10-week COIL timeline and intercultural interaction.
3.  **Team Directory:** Highlight the transatlantic cooperation between researchers and students.
4.  **Dissemination:** Host updates, news, publications, and the "Crossing Waves" podcast.

---

## 🛠️ Technologies & Architecture

This project was built with a focus on **Performance**, **Accessibility**, and **Maintainability**.

* **HTML5:** Strictly semantic markup for optimal SEO and screen reader compatibility.
* **CSS Framework:** [Tailwind CSS](https://tailwindcss.com/).
    * *Note:* Currently running via CDN for rapid prototyping and ease of development without a Node.js build step.
* **JavaScript:** Vanilla JS (ES6+) for UI interactions (mobile menu, filtering logic) to ensure maximum performance and zero dependencies.
* **Icons:** [Phosphor Icons](https://phosphoricons.com/) (via Script).
* **Fonts:** `Merriweather` (Serif for headings) and `Inter` (Sans for body) via Google Fonts.

---

## 🎨 Design System: "Academic Clarity"

The UI was designed to balance the tradition of Durham University with modern web usability standards.

* **Primary Color:** Durham Purple (`#68246D`) used for actions and highlights.
* **Typography:** High contrast pairing (Serif/Sans) to ensure readability.
* **Visuals:** Extensive use of whitespace, rounded corners (8px-12px), and subtle shadows to create depth without clutter.
* **Accessibility:**
    * Contrast ratios checked for WCAG AA/AAA compliance.
    * Full keyboard navigation support (visible focus states).
    * Semantic heading structure (H1-H4).

---

## 🚀 Getting Started

Since this project currently uses Tailwind via CDN, no build process (`npm install`, etc.) is required to view it.

### Prerequisites
* A modern web browser (Chrome, Firefox, Edge, Safari).

### Installation
1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/your-username/crossing-boundaries-site.git](https://github.com/your-username/crossing-boundaries-site.git)
    ```
2.  **Open the project:**
    Simply navigate to the folder and open `index.html` (or `index_en.html` for the English version) in your browser.

---

## 📂 Project Structure

```text
/
├── index.html          # Main Homepage (Portuguese Version)
├── index_en.html       # Main Homepage (English Version)
├── assets/             # Images, PDFs, and static files
│   └── ...
└── README.md           # Project Documentation


