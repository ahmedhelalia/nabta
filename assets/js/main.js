

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');

        if (targetId === '#') return;

        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 80,
                behavior: 'smooth'
            });
        }
    });
});

// Add animation on scroll for sections
const sections = document.querySelectorAll('section');

function checkSections() {
    const triggerBottom = window.innerHeight * 0.8;

    sections.forEach(section => {
        const sectionTop = section.getBoundingClientRect().top;

        if (sectionTop < triggerBottom) {
            section.classList.add('animate');
        }
    });
}

window.addEventListener('scroll', checkSections);
checkSections(); // Check on initial load

// Mobile navigation toggle
const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
const navItems = document.querySelector('.nav_items');

mobileNavToggle.addEventListener('click', () => {
    navItems.classList.toggle('active');
    const icon = mobileNavToggle.querySelector('i');
    icon.classList.toggle('uil-bars');
    icon.classList.toggle('uil-times');
});

// Close mobile menu when clicking outside
document.addEventListener('click', (e) => {
    if (!navItems.contains(e.target) && !mobileNavToggle.contains(e.target)) {
        navItems.classList.remove('active');
        const icon = mobileNavToggle.querySelector('i');
        icon.classList.remove('uil-times');
        icon.classList.add('uil-bars');
    }
});
// Dashboard sidebar toggle
const showSidebarBtn = document.querySelector('#show__sidebar-btn');
const hideSidebarBtn = document.querySelector('#hide__sidebar-btn');
const sidebar = document.querySelector('.dashboard aside');

if(showSidebarBtn) {
    showSidebarBtn.addEventListener('click', () => {
        sidebar.classList.add('show');
        showSidebarBtn.style.display = 'none';
        hideSidebarBtn.style.display = 'flex';
    });
}

if(hideSidebarBtn) {
    hideSidebarBtn.addEventListener('click', () => {
        sidebar.classList.remove('show');
        showSidebarBtn.style.display = 'flex';
        hideSidebarBtn.style.display = 'none';
    });
}

// Close sidebar when clicking outside on mobile
document.addEventListener('click', (e) => {
    if(window.innerWidth < 992) {
        if(!sidebar.contains(e.target) && 
           !showSidebarBtn.contains(e.target) && 
           !hideSidebarBtn.contains(e.target)) {
            sidebar.classList.remove('show');
            showSidebarBtn.style.display = 'flex';
            hideSidebarBtn.style.display = 'none';
        }
    }
});
// chat bot
document.addEventListener('DOMContentLoaded', function () {
    const chatButton = document.querySelector('.chat-button');
    const chatContainer = document.querySelector('.chat-container');
    const chatInput = document.querySelector('.chat-input input');
    const chatSend = document.querySelector('.chat-input button');
    const chatMessages = document.querySelector('.chat-messages');

    // Toggle chat window
    chatButton.addEventListener('click', () => {
        chatContainer.style.display = chatContainer.style.display === 'none' ? 'block' : 'none';
    });

    // Send message function
    function sendMessage(message) {
        // Add user message
        const userMessage = document.createElement('div');
        userMessage.className = 'message user-message';
        userMessage.textContent = message;
        chatMessages.appendChild(userMessage);

        // Simple bot responses based on keywords
        setTimeout(() => {
            const botMessage = document.createElement('div');
            botMessage.className = 'message bot-message';

            if (message.includes('مرحبا') || message.includes('السلام عليكم')) {
                botMessage.textContent = 'مرحباً بك! كيف يمكنني مساعدتك اليوم؟';
            } else if (message.includes('استشارة') || message.includes('مشكلة')) {
                botMessage.textContent = 'يمكنك حجز استشارة مع أحد خبرائنا من خلال قسم الاستشارات';
            } else if (message.includes('دورة') || message.includes('تدريب')) {
                botMessage.textContent = 'لدينا العديد من الدورات التدريبية المتخصصة، يمكنك استعراضها في قسم الدورات';
            } else {
                botMessage.textContent = 'عذراً، لم أفهم سؤالك. هل يمكنك إعادة صياغته بطريقة أخرى؟';
            }
            chatMessages.appendChild(botMessage);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }, 500);
    }

    // Handle send button click
    chatSend.addEventListener('click', () => {
        const message = chatInput.value.trim();
        if (message) {
            sendMessage(message);
            chatInput.value = '';
        }
    });

    // Handle enter key
    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            const message = chatInput.value.trim();
            if (message) {
                sendMessage(message);
                chatInput.value = '';
            }
        }
    });
});