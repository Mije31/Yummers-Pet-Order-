function showForm(tabId) {
        // Get all faq-list divs
        const faqLists = document.querySelectorAll('.faq-list');
        // Get all tab divs
        const tabs = document.querySelectorAll('.tabs .tab');
        // Get all faq-item elements within the current tab's list
        const currentFaqItems = document.querySelectorAll(`#${tabId} .faq-item`);

        // Deactivate all tabs and hide all faq lists
        tabs.forEach(tab => tab.classList.remove('active'));
        faqLists.forEach(list => list.style.display = 'none');

        // Activate the clicked tab and show the corresponding faq list
        const activeTab = document.querySelector(`.tabs .tab[onclick="showForm('${tabId}')"]`);
        const activeList = document.getElementById(tabId);

        if (activeTab) {
            activeTab.classList.add('active');
        }
        if (activeList) {
            activeList.style.display = 'block';
        }

        // Close any open answers in the newly displayed tab
        currentFaqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');
            question.classList.remove('open');
            answer.style.display = 'none';
        });
    }

    // Add event listeners for expanding/collapsing FAQ items
    document.addEventListener('DOMContentLoaded', function() {
        const faqLists = document.querySelectorAll('.faq-list');

        faqLists.forEach(list => {
            const faqItems = list.querySelectorAll('.faq-item');
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                question.addEventListener('click', function() {
                    const answer = this.nextElementSibling;
                    const isOpen = this.classList.contains('open');

                    // Close all open answers in the current FAQ list
                    const currentListItems = this.closest('.faq-list').querySelectorAll('.faq-item');
                    currentListItems.forEach(otherItem => {
                        const otherQuestion = otherItem.querySelector('.faq-question');
                        const otherAnswer = otherItem.querySelector('.faq-answer');
                        if (otherQuestion !== this) {
                            otherQuestion.classList.remove('open');
                            otherAnswer.style.display = 'none';
                        }
                    });

                    // Toggle the current answer
                    this.classList.toggle('open');
                    answer.style.display = isOpen ? 'none' : 'block';
                });
            });
        });
    });

    function delivery() {
    // automatically sends email
    window.location.href = "mailto:Yummersdelivery@gmail.com";
    }

       function refunds() {
    // automatically sends email
    window.location.href = "mailto:Yummersrefunds@gmail.com";
    }

       function subscription() {
    // automatically sends email
    window.location.href = "mailto:Yummerssubscription@gmail.com";
    }

       function petsclub() {
    // automatically sends email
    window.location.href = "mailto:Yummerspetsclub@gmail.com";
    }

       function support() {
    // automatically sends email
    window.location.href = "mailto:Yummerssupport@gmail.com";
    }
