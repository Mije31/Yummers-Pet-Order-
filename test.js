// Menu toggle functionality
document.addEventListener('DOMContentLoaded', function() {
  // Sidebar menu functionality
  const menutoggle = document.getElementById('menutoggle');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const closebtn = document.getElementById('closebtn');

  if (menutoggle) {
      menutoggle.addEventListener('click', function() {
          sidebar.classList.add('active');
          overlay.classList.add('active');
          document.body.style.overflow = 'hidden';  // Prevent scrolling
      });
  }

  if (closebtn) {
      closebtn.addEventListener('click', function() {
          sidebar.classList.remove('active');
          overlay.classList.remove('active');
          document.body.style.overflow = '';  // Restore scrolling
      });
  }

  if (overlay) {
      overlay.addEventListener('click', function() {
          sidebar.classList.remove('active');
          overlay.classList.remove('active');
          document.body.style.overflow = '';  // Restore scrolling
      });
  }

  // Dark mode toggle
  const checkbox = document.getElementById('checkbox');
  if (checkbox) {
      const savedTheme = localStorage.getItem('theme');
      if (savedTheme === 'dark') {
          document.body.classList.add('dark-theme');
          checkbox.checked = true;
      }

      checkbox.addEventListener('change', function() {
          document.body.classList.toggle('dark-theme');
          const theme = document.body.classList.contains('dark-theme') ? 'dark' : 'light';
          localStorage.setItem('theme', theme);
      });
  }

  // FAQ tab switching functionality
  const faqContent = {
      'collection-delivery': `
          <div class="faq-item">
              <div class="faq-question">
                  <span>1. Where is my order?</span>
                  <div class="icon">+</div>
              </div>
              <div class="faq-answer">
                  <p>To track your order, you have a couple of convenient options:</p>
                  <ul>
                      <li>Already Signed In? Just head over to 'My Account' and find your order details there.</li>
                      <li>Not signed in or guest order? Use the tracking feature <a href="#">here</a>. Just make sure to have your order number and email address ready.</li>
                  </ul>
                  <p>And don't forget, if you're browsing our support page, you can use the handy 'Where is My Order' section to quickly track your order by entering your order number and email address.</p>
                  <p>We are currently transitioning to our new warehouse, and there may be a delay to a small number of orders. Please bear with us during this time.</p>
              </div>
          </div>
          
          <div class="faq-item">
              <div class="faq-question">
                  <span>2. How long do home delivery orders take?</span>
                  <div class="icon">+</div>
              </div>
              <div class="faq-answer">
                  <p>Our standard home delivery typically takes 2-4 business days from the time your order is processed. Premium delivery options are available at checkout for faster service.</p>
                  <p>Please note that delivery times may vary based on your location and current demand. During peak periods and holidays, delivery might take slightly longer.</p>
              </div>
          </div>
          
          <div class="faq-item">
              <div class="faq-question">
                  <span>3. How long does Click & Collect take?</span>
                  <div class="icon">+</div>
              </div>
              <div class="faq-answer">
                  <p>Our Click & Collect service is usually ready within 2 hours during store opening hours for in-stock items. You'll receive a confirmation email when your order is ready for collection.</p>
                  <p>For orders placed outside of store hours, your items will be ready for collection when the store next opens.</p>
              </div>
          </div>
          
          <div class="faq-item">
              <div class="faq-question">
                  <span>4. How long do I have to collect my Click & Collect order?</span>
                  <div class="icon">+</div>
              </div>
              <div class="faq-answer">
                  <p>You have 7 days to collect your Click & Collect order from the time you receive the "ready for collection" notification.</p>
                  <p>If you're unable to collect within this timeframe, please contact our customer service team, and we can arrange to hold your order for longer.</p>
              </div>
          </div>
          
          <div class="faq-item">
              <div class="faq-question">
                  <span>5. Can I book a delivery slot?</span>
                  <div class="icon">+</div>
              </div>
              <div class="faq-answer">
                  <p>Yes, you can book a specific delivery slot during checkout for an additional fee. We offer morning, afternoon, and evening slots on most weekdays.</p>
                  <p>Premium delivery services with time-specific slots are available in selected postcodes. Enter your postcode during checkout to see available options.</p>
              </div>
          </div>
      `,
      'refunds-returns': `
          <div class="faq-item">
              <div class="faq-question">
                  <span>1. I would like to return my item for a refund, what do I need to do?</span>
                  <div class="icon">+</div>
              </div>
              <div class="faq-answer">
                  <p>To return an item for a refund, please follow these steps:</p>
                  <ul>
                      <li>Ensure your item is in its original condition with all packaging and tags attached.</li>
                      <li>Log into your account and select the order containing the item you wish to return.</li>
                      <li>Select "Return Item" and follow the on-screen instructions to generate a return label.</li>
                      <li>Package your item securely and attach the return label.</li>
                      <li>Drop off your package at any authorized shipping location within 30 days of delivery.</li>
                  </ul>
                  <p>If you made your purchase as a guest, you can initiate a return using your order number and the email address used during checkout on our <a href="#">Returns Portal</a>.</p>
              </div>
          </div>
          
          <div class="faq-item">
              <div class="faq-question">
                  <span>2. What is your return policy?</span>
                  <div class="icon">+</div>
              </div>
              <div class="faq-answer">
                  <p>Our return policy offers you 30 days from the date of delivery to return most unused items in their original condition for a full refund. Please note the following:</p>
                  <ul>
                      <li>Items must be unused, undamaged, and in their original packaging with all tags attached.</li>
                      <li>Certain products, including food, opened pet medication, and personalized items, cannot be returned unless they are faulty.</li>
                      <li>For hygiene reasons, opened pet beds, clothing, and grooming products cannot be returned unless they are faulty.</li>
                      <li>Return shipping is free for faulty items or incorrect orders. For preference-based returns, a return shipping fee may apply.</li>
                  </ul>
                  <p>For complete details, please visit our <a href="#">full Returns Policy page</a>.</p>
              </div>
          </div>
          
          <div class="faq-item">
              <div class="faq-question">
                  <span>3. When will I receive my refund?</span>
                  <div class="icon">+</div>
              </div>
              <div class="faq-answer">
                  <p>Once we receive your returned item, here's what happens:</p>
                  <ul>
                      <li>We'll inspect the item to ensure it meets our return policy requirements.</li>
                      <li>Once approved, we'll process your refund within 3-5 business days.</li>
                      <li>The refund will be issued to your original payment method.</li>
                      <li>Credit and debit card refunds typically take an additional 3-7 business days to appear in your account, depending on your bank's policies.</li>
                  </ul>
                  <p>You'll receive an email confirmation once your refund has been processed. If you haven't received your refund after 10 business days from our confirmation email, please contact our customer service team.</p>
              </div>
          </div>
          
          <div class="faq-item">
              <div class="faq-question">
                  <span>4. My item has developed a fault within its twelve month guarantee, what do I need to do?</span>
                  <div class="icon">+</div>
              </div>
              <div class="faq-answer">
                  <p>If your item has developed a fault within the twelve-month guarantee period, please follow these steps:</p>
                  <ul>
                      <li>Contact our customer service team through your account or via our <a href="#">Contact Us</a> page.</li>
                      <li>Provide your order number, a description of the fault, and if possible, photos showing the issue.</li>
                      <li>Our team will assess your claim and provide instructions on next steps, which may include returning the item for inspection.</li>
                      <li>Return shipping for faulty items is free - we'll provide a prepaid return label.</li>
                  </ul>
                  <p>Once we receive and verify the faulty item, we'll offer you a replacement, repair, or refund based on your preference. Our twelve-month guarantee covers manufacturing defects but does not cover damage due to normal wear and tear or misuse.</p>
              </div>
          </div>
      `,
      'pets-club': `
          <div class="faq-item">
              <div class="faq-question">
                  <span>1. How do I join the Pets Club?</span>
                  <div class="icon">+</div>
              </div>
              <div class="faq-answer">
                  <p>Joining our Pets Club is easy and free! Simply create an account on our website or app, and opt in to the Pets Club during registration or through your account settings.</p>
              </div>
          </div>
      `,
      'subscription-repeat': `
          <div class="faq-item">
              <div class="faq-question">
                  <span>1. How do I set up a subscription?</span>
                  <div class="icon">+</div>
              </div>
              <div class="faq-answer">
                  <p>You can set up a subscription for eligible items by selecting the "Subscribe & Save" option during checkout. Choose your preferred delivery frequency, and we'll automatically ship your items on schedule.</p>
              </div>
          </div>
      `,
      'website-app': `
          <div class="faq-item">
              <div class="faq-question">
                  <span>1. I'm having trouble with the website or app, what should I do?</span>
                  <div class="icon">+</div>
              </div>
              <div class="faq-answer">
                  <p>If you're experiencing technical difficulties, try clearing your browser cache or reinstalling the app. If problems persist, please contact our support team.</p>
              </div>
          </div>
      `,
      'pets': `
          <div class="faq-item">
              <div class="faq-question">
                  <span>1. Do you sell pets?</span>
                  <div class="icon">+</div>
              </div>
              <div class="faq-answer">
                  <p>We do not sell pets directly. We focus on providing high-quality pet supplies, food, and accessories. For pet adoption, we recommend contacting local animal shelters or rescue organizations.</p>
              </div>
          </div>
      `,
      'other': `
          <div class="faq-item">
              <div class="faq-question">
                  <span>1. How do I contact customer service?</span>
                  <div class="icon">+</div>
              </div>
              <div class="faq-answer">
                  <p>You can reach our customer service team through multiple channels:</p>
                  <ul>
                      <li>Live chat on our website (available 8am-8pm daily)</li>
                      <li>Email at support@yummers.com</li>
                      <li>Phone at 1-800-YUM-PETS (available 9am-6pm weekdays)</li>
                  </ul>
              </div>
          </div>
      `
  };

  // Set up tab click handlers
  const tabs = document.querySelectorAll('.tabs .tab');
  if (tabs.length > 0) {
      tabs.forEach((tab) => {
          tab.addEventListener('click', function() {
              // Remove active class from all tabs
              tabs.forEach(t => t.classList.remove('active'));
              
              // Add active class to clicked tab
              this.classList.add('active');
              
              // Determine which content to show based on tab text
              let contentKey;
              const tabText = this.textContent.trim().toLowerCase();
              
              if (tabText.includes('collection')) contentKey = 'collection-delivery';
              else if (tabText.includes('refunds')) contentKey = 'refunds-returns';
              else if (tabText.includes('pets club')) contentKey = 'pets-club';
              else if (tabText.includes('subscription')) contentKey = 'subscription-repeat';
              else if (tabText.includes('website')) contentKey = 'website-app';
              else if (tabText === 'pets') contentKey = 'pets';
              else contentKey = 'other';
              
              // Update content
              const faqList = document.querySelector('.faq-list');
              if (faqList) {
                  faqList.innerHTML = faqContent[contentKey];
                  
                  // Add event listeners to new FAQ items
                  attachFaqEventListeners();
              }
          });
      });
  }

  // Function to handle FAQ question expansion/collapse
  function attachFaqEventListeners() {
      const faqQuestions = document.querySelectorAll('.faq-question');
      
      faqQuestions.forEach(question => {
          question.addEventListener('click', function() {
              const answer = this.nextElementSibling;
              const icon = this.querySelector('.icon');
              
              // Close other answers
              document.querySelectorAll('.faq-answer').forEach(openAnswer => {
                  if (openAnswer !== answer && openAnswer.classList.contains('active')) {
                      openAnswer.classList.remove('active');
                      const questionIcon = openAnswer.previousElementSibling.querySelector('.icon');
                      if (questionIcon) questionIcon.textContent = '+';
                  }
              });
              
              // Toggle this answer
              answer.classList.toggle('active');
              if (icon) {
                  icon.textContent = answer.classList.contains('active') ? '−' : '+';
              }
          });
      });
  }

  // Initial FAQ event listener setup
  attachFaqEventListeners();
});