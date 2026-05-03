<?php include("../includes/header.php"); ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@300;400;600&display=swap');

    body { background-color: #F8F7F4; font-family: 'Inter', sans-serif; color: #1A1A1A; }

    .privacy-wrapper { 
        max-width: 850px; 
        margin: 150px auto 100px; 
        padding: 80px; 
        background: #FFFFFF; 
        border: 1px solid #E5E0D8;
        box-shadow: 0 15px 45px rgba(0,0,0,0.02);
    }

    .privacy-header { text-align: center; margin-bottom: 80px; }
    
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

    .privacy-section { 
        margin-bottom: 60px; 
        display: flex;
        gap: 30px;
    }

    .section-icon {
        font-size: 24px;
        color: #1A1A1A;
        opacity: 0.8;
        padding-top: 5px;
    }

    .section-content h5 { 
        font-family: 'Playfair Display', serif; 
        font-size: 20px; 
        font-weight: 700; 
        margin-bottom: 15px; 
        color: #1A1A1A;
        letter-spacing: 0.5px;
    }

    .section-content p { 
        font-size: 15px; 
        line-height: 1.8; 
        color: #555; 
        margin: 0;
    }

    .email-link {
        color: #1A1A1A;
        font-weight: 600;
        text-decoration: none;
        border-bottom: 1px solid #1A1A1A;
        transition: 0.3s;
    }

    .email-link:hover {
        opacity: 0.6;
    }

    .signature { 
        margin-top: 80px; 
        font-family: 'Playfair Display', serif; 
        font-style: italic; 
        text-align: center; 
        color: #AAA;
        font-size: 18px;
    }

    @media (max-width: 768px) {
        .privacy-wrapper { padding: 40px 20px; margin-top: 100px; }
        .privacy-section { flex-direction: column; gap: 10px; }
        h2 { font-size: 32px; }
    }
</style>

<div class="container">
    <div class="privacy-wrapper">
        
        <div class="privacy-header">
            <h2>Privacy Policy</h2>
            <div class="divider"></div>
        </div>

        <!-- Section 1 -->
        <div class="privacy-section">
            <div class="section-icon">✦</div>
            <div class="section-content">
                <h5>Data Collection</h5>
                <p>
                    We believe in radical transparency. Maison NYA exclusively collects essential information required for an exceptional shopping experience, including your name, email address, phone number, and transaction history.
                </p>
            </div>
        </div>

        <!-- Section 2 -->
        <div class="privacy-section">
            <div class="section-icon">✦</div>
            <div class="section-content">
                <h5>Purpose of Processing</h5>
                <p>
                    Your data is a private asset. We utilize this information solely for the purpose of personalized account management and the seamless execution of your orders within our boutique.
                </p>
            </div>
        </div>

        <!-- Section 3 -->
        <div class="privacy-section">
            <div class="section-icon">✦</div>
            <div class="section-content">
                <h5>Data Integrity & Security</h5>
                <p>
                    Security is at the heart of our architecture. All personal data is stored within a high-security MySQL database, strictly hosted in a local environment to ensure maximum privacy and protection.
                </p>
            </div>
        </div>

        <!-- Section 4 -->
        <div class="privacy-section">
            <div class="section-icon">✦</div>
            <div class="section-content">
                <h5>The Cookie Experience</h5>
                <p>
                    Maison NYA utilizes cookies to refine your journey on our platform. These small digital markers allow us to remember your preferences and ensure a fluid, high-fidelity user interface.
                </p>
            </div>
        </div>

        <!-- Section 5 -->
        <div class="privacy-section">
            <div class="section-icon">✦</div>
            <div class="section-content">
                <h5>Concierge & Support</h5>
                <p>
                    For any inquiries regarding your personal data or to exercise your rights, please contact our dedicated support at: 
                    <a href="mailto:yousraderbel30600@gmail.com" class="email-link">yousraderbel30600@gmail.com</a>
                </p>
            </div>
        </div>

        <div class="signature">
            — Maison NAYA, 2026
        </div>

    </div>
</div>

<?php include("../includes/footer.php"); ?>