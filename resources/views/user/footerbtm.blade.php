<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<style>
    .ft-bottom {
        font-size: 13px;
        text-align: center;
        background-color: #222222;
        letter-spacing: 1px;
        padding: 30px 0;
    }

    .ft-bottom p {
        color: #BDBDBD;
        margin: 0;
    }

    .ft-bottom p a {
        color: #BDBDBD;
        text-decoration: none;
    }

    .hidden {
        display: none;
    }

    .popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 10001;
        transition: transform 0.3s ease-in-out;
        width: 80%;
        overflow: hidden;
        max-width: 800px;
    }

    .popup.show {
        transform: translate(-50%, -50%) scale(1);
    }

    .popup-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-radius: 10px 10px 0 0;
        border-bottom: 1px solid #ddd;
        background-color: #f9f9f9;
        position: sticky;
        top: 0;
        z-index: 10002;
    }

    .popup-header h5 {
        margin: 0;
        font-size: 1.2em;
    }

    .button-container {
        margin: 0;
    }

    button.btn-close {
        background: none;
        border: none;
        font-size: 1.5em;
        cursor: pointer;
        padding: 0;
    }

    button.btn-close:focus,
    button.btn-close:active {
        box-shadow: none;
    }
    .popup-content p{
        color: #666;
    }
    .popup-content li {
        color: #689;
        padding-left: 30px;
    }

    .popup-content {
        list-style: 1.75;
        max-height: 70vh;
        overflow-y: auto;
        padding: 20px;
        scroll-behavior: smooth;
    }

    .popup-content::-webkit-scrollbar {
        width: 10px;
    }

    .popup-content::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }

    .popup-content::-webkit-scrollbar-thumb:hover {
        background: rgba(0, 0, 0, 0.3);
    }

    #privacy-button,
    #terms-button {
        color: #BDBDBD;
        background-color: transparent;
        border: none;
    }
</style>

<body>
    <div class="ft-bottom d-flex justify-content-center">
        <p>© 2024 Rager | <button id="privacy-button">Privacy policy</button> | <button id="terms-button">Terms of
                Use</button></p>
    </div>

    <!-- Privacy Policy Popup -->
    <div id="privacy-popup" class="popup hidden">
        <div class="popup-header">
            <h5>Privacy Policy</h5>
            <div class="button-container">
                <button id="close-privacy-popup" class="btn-close"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
        <div class="popup-content">
            <h6>
                <strong>
                    Effective Date: July 1, 2024<br><br>
                    1. Introduction
                </strong>
            </h6>
            <p>
                Welcome to Rager Clothing. We are committed to protecting your personal information and your right to
                privacy. If you have any questions or concerns about this privacy policy or our practices with regards
                to your personal information, please contact us at ragerclothing0@gmail.com.
            </p>
            <h6><strong>2. Information We Collect</strong></h6>
            <p>
                We collect personal information that you voluntarily provide to us when you make a purchase, sign up for
                our newsletter, or otherwise contact us. <br><br>
                The personal information we collect can include the following:
                <li>
                    <strong>Purchases / Orders:</strong> You give us personal information about you when you place an
                    order on any of our
                    platforms. This generally includes the contents of your shopping cart, your name, email address,
                    phone number, shipping address, delivery preferences, and payment details.
                </li>
            </p>
            <h6><strong>3. How We Use Your Information</strong></h6>
            <p>
                We use personal information collected via our website for a variety of business purposes described
                below:

                <li>To process and manage your orders.</li>
                <li>To send administrative information to you (e.g., order confirmations, invoices, etc.).</li>
                <li>To send you marketing and promotional communications (if you have opted in to receive such
                    communications).</li>
                <li>To improve our website and services.</li>
                <li>To protect our services.</li>
                <li>To enforce our terms, conditions, and policies.</li>
                <li>To comply with legal obligations.</li>
            </p>
            <h6><strong>4. Sharing Your Information</strong></h6>
            <p>
                We may process or share data based on the following legal basis:
                <li><strong>Consent:</strong> We may process your data if you have given us specific consent to use your
                    personal information for a specific purpose.
                </li>
                <li><strong>Legitimate Interests:</strong> We may process your data when it is reasonably necessary to
                    achieve our legitimate business interests.
                </li>
                <li><strong>Legal Obligations:</strong> We may disclose your information where we are legally required
                    to do so to comply with applicable law, governmental requests, a judicial proceeding, court order,
                    or legal process.
                </li>
            </p>
            <h6><strong>5. Data Security</strong></h6>
            <p>
                We have implemented appropriate technical and organizational security measures designed to protect the
                security of any personal information we process. However, please also remember that we cannot guarantee
                that the internet itself is 100% secure. Although we will do our best to protect your personal
                information, transmission of personal information to and from our website is at your own risk.
            </p>
            <h6><strong>6. Your Privacy Rights</strong></h6>
            <p>
                In some regions, such as the Philippines, you have certain rights under applicable data protection laws.
                Under the Philippines' Data Privacy Act of 2012, these rights include:
                <li><strong>To Be Informed:</strong> You have the right to be informed whether personal information
                    pertaining to you shall be, are being, or have been processed.
                </li>
                <li><strong>To Access:</strong> You have the right to reasonable access, upon demand, to your personal
                    information.
                </li>
                <li><strong>To Rectification:</strong> You have the right to reasonable access, upon demand, to your
                    personal
                    information.
                </li>
                <li><strong>To Erasure or Blocking:</strong> You have the right to suspend, withdraw, or order the
                    blocking, removal, or destruction of your personal information.
                </li>
                <li><strong>To Object:</strong> You have the right to object to the processing of your personal
                    information, including processing for direct marketing, automated processing, or profiling.
                </li>
                <li><strong>To Data Portability:</strong> You have the right to obtain a copy of your personal
                    information in an electronic or structured format.
                </li>
            </p>
            <h6><strong>7. Updates to This Policy</strong></h6>
            <p>
                We may update this privacy policy from time to time. The updated version will be indicated by an updated
                "Effective Date" and the updated version will be effective as soon as it is accessible. We encourage you
                to review this privacy policy frequently to be informed of how we are protecting your information.
            </p>
            <h6><strong>8. Contact Us</strong></h6>
            <p>If you have questions or comments about this policy, you may contact us at:
                <strong>ragerclothing0@gmail.com</strong>
            </p>
        </div>
    </div>

    <!-- Terms of Use Popup -->
    <div id="terms-popup" class="popup hidden">
        <div class="popup-header">
            <h5>Terms of Use</h5>
            <div class="button-container">
                <button id="close-terms-popup" class="btn-close"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
        <div class="popup-content">
            <h6>
                <strong>
                    Effective Date: July 1, 2024<br><br>
                    1. Acceptance of Terms
                </strong>
            </h6>
            <p>
                By accessing and using the website of Rager Clothing, located at www.ragerclothing.com, you agree to
                comply with and be bound by these Terms of Use. If you do not agree to these terms, you should not
                use our website.
            </p>
            <h6><strong>2. Changes to Terms</strong></h6>
            <p>
                We reserve the right to modify these Terms of Use at any time. Any changes will be effective
                immediately upon posting on our website. Your continued use of the website following the posting of
                revised Terms of Use means that you accept and agree to the changes.
            </p>
            <h6><strong>3. User Responsibilities</strong></h6>
            <p>
                As a user of our website, you agree to:
                <li>Provide accurate and current information during the purchase process.</li>
                <li>Maintain the security and confidentiality of your account information.</li>
                <li>Refrain from using our website for any illegal or unauthorized purposes.</li>
                <li>Comply with all applicable local, state, national, and international laws and regulations.</li>
            </p>
            </p>
            <h6><strong>4. Purchases</strong></h6>
            <p>
                When you make a purchase on our website, you agree to the following terms:
                <li><strong>Pricing and Availability:</strong> All prices are listed in Peso and are subject to change
                    without notice. We reserve the right to limit the quantity of any item sold.
                </li>
                <li><strong>Order Acceptance:</strong> We reserve the right to refuse or cancel any order for any
                    reason, including inaccuracies or errors in product or pricing information.
                </li>
                <li><strong>Payment:</strong> You agree to provide valid payment information and authorize us to charge
                    your payment method for the total amount of your order.
                </li>
                <li><strong>Shipping:</strong> Shipping and delivery times are estimates and may vary. We are not
                    responsible for any delays in delivery.
                </li>
            </p>
            <h6><strong>5. Returns and Refunds</strong></h6>
            <p>
                We want you to be completely satisfied with your purchase from Rager Clothing. If for any reason you are
                not satisfied, we offer a straightforward return and refund policy:
                <li>You may return any unused, unworn, or defective merchandise purchased from Rager Clothing within 30
                    days of the delivery date.</li>
                <li>Returned items must be in their original packaging, including all tags and accessories.</li>
                <li>Once your return is received and inspected, we will send you an email to notify you that we have
                    received your returned item. We will also notify you of the approval or rejection of your refund.
                </li>
                <li>Please note that refunds for returned items depend on our courier, J&T. If you need to arrange a
                    refund, please coordinate directly with J&T courier.</li>
            </p>
            <h6><strong>6. Intellectual Property</strong></h6>
            <p>
                All content on our website, including but not limited to text, graphics, logos, images, and software, is
                the property of Rager Clothing or its content suppliers and is protected by copyright, trademark, and
                other intellectual property laws. You may not use, reproduce, distribute, or display any content without
                our prior written consent.
            </p>
            <h6><strong>7. Limitation of Liability</strong></h6>
            <p>
                To the fullest extent permitted by law, Rager Clothing shall not be liable for any direct, indirect,
                incidental, special, or consequential damages resulting from your use of or inability to use our
                website, including but not limited to damages for loss of profits, data, or other intangible losses.
            </p>
            <h6><strong>8. Disclaimer of Warranties</strong></h6>
            <p>
                Our website and all content and services provided on or through our website are provided on an "as is"
                and "as available" basis without any warranties of any kind, either express or implied, including but
                not limited to implied warranties of merchantability, fitness for a particular purpose, or
                non-infringement.
            </p>10. Contact Us</strong></h6>
            <p>If you have any questions about these Terms of Use, you may contact us at:
                <strong>ragerclothing0@gmail.com</strong>
            </p>
        </div>
    </div>

    <script>
        document.getElementById('privacy-button').addEventListener('click', function () {
            document.getElementById('privacy-popup').classList.remove('hidden');
            setTimeout(function () {
                document.getElementById('privacy-popup').classList.add('show');
            }, 10); // Small delay to trigger the transition
        });

        document.getElementById('close-privacy-popup').addEventListener('click', function () {
            document.getElementById('privacy-popup').classList.remove('show');
            setTimeout(function () {
                document.getElementById('privacy-popup').classList.add('hidden');
            }, 300); // Wait for the transition to complete
        });

        document.getElementById('terms-button').addEventListener('click', function () {
            document.getElementById('terms-popup').classList.remove('hidden');
            setTimeout(function () {
                document.getElementById('terms-popup').classList.add('show');
            }, 10); // Small delay to trigger the transition
        });

        document.getElementById('close-terms-popup').addEventListener('click', function () {
            document.getElementById('terms-popup').classList.remove('show');
            setTimeout(function () {
                document.getElementById('terms-popup').classList.add('hidden');
            }, 300); // Wait for the transition to complete
        });

        // Close the popups when clicking outside of them
        window.addEventListener('click', function (event) {
            const privacyPopup = document.getElementById('privacy-popup');
            const termsPopup = document.getElementById('terms-popup');
            if (!privacyPopup.contains(event.target) && !document.getElementById('privacy-button').contains(event.target)) {
                if (privacyPopup.classList.contains('show')) {
                    privacyPopup.classList.remove('show');
                    setTimeout(function () {
                        privacyPopup.classList.add('hidden');
                    }, 300); // Wait for the transition to complete
                }
            }
            if (!termsPopup.contains(event.target) && !document.getElementById('terms-button').contains(event.target)) {
                if (termsPopup.classList.contains('show')) {
                    termsPopup.classList.remove('show');
                    setTimeout(function () {
                        termsPopup.classList.add('hidden');
                    }, 300); // Wait for the transition to complete
                }
            }
        });
    </script>
</body>

</html>