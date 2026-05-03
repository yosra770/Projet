<?php include("../includes/header.php"); ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@300;400;600&display=swap');

    body { background-color: #F8F7F4; font-family: 'Inter', sans-serif; color: #1A1A1A; }

    .legal-wrapper { 
        max-width: 850px; 
        margin: 150px auto 100px; 
        padding: 80px; 
        background: #FFFFFF; 
        border: 1px solid #E5E0D8;
        box-shadow: 0 15px 45px rgba(0,0,0,0.02);
    }

    .legal-header { text-align: center; margin-bottom: 80px; }
    
    h2 { 
        font-family: 'Playfair Display', serif; 
        font-size: 48px; 
        margin-bottom: 20px; 
        letter-spacing: -1px;
    }

    .divider { 
        width: 40px; 
        height: 2px; 
        background: #1A1A1A; 
        margin: 0 auto; 
    }

    section { margin-bottom: 50px; }

    h5 { 
        font-family: 'Playfair Display', serif; 
        font-size: 20px; 
        font-weight: 700; 
        margin-bottom: 18px; 
        color: #1A1A1A;
        letter-spacing: 0.5px;
    }

    p { 
        font-size: 15px; 
        line-height: 1.9; 
        color: #555; 
        text-align: justify;
    }

    .signature { 
        margin-top: 80px; 
        font-family: 'Playfair Display', serif; 
        font-style: italic; 
        text-align: center; 
        color: #AAA;
        font-size: 18px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .legal-wrapper { padding: 40px 20px; margin-top: 100px; }
        h2 { font-size: 32px; }
    }
</style>

<div class="container">
    <div class="legal-wrapper">
        
        <div class="legal-header">
            <h2>Legal Notice</h2>
            <div class="divider"></div>
        </div>

        <section>
            <h5>Website Publisher</h5>
            <p>
                The <strong>Maison NYA</strong> digital platform is a curated space developed and published by Yosra and Nada. This project was conceived as an academic excellence initiative, showcasing the intersection of modern technology and luxury retail.
            </p>
        </section>

        <section>
            <h5>Hosting & Infrastructure</h5>
            <p>
                To ensure a refined development environment, this website is currently hosted within a controlled local infrastructure using <strong>XAMPP</strong> (incorporating Apache HTTP Server and MySQL databases). 
            </p>
        </section>

        <section>
            <h5>Intellectual Property</h5>
            <p>
                The visual identity, architectural design, high-fidelity imagery, and editorial content found on this site are the exclusive property of the <strong>Maison NYA</strong> project. Any reproduction, total or partial, without explicit consent is strictly prohibited and protected under creative rights.
            </p>
        </section>

        <section>
            <h5>Liability & Terms</h5>
            <p>
                While Maison NYA strives to provide a seamless user experience, we cannot be held responsible for technical interruptions, data inaccuracies, or bugs inherent to local server environments or user-side browser compatibility.
            </p>
        </section>

        <div class="signature">
            — Maison NAYA, 2026
        </div>

    </div>
</div>

<?php include("../includes/footer.php"); ?>