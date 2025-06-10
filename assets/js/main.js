

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
const mobile_overlay = document.createElement('div');
mobile_overlay.className = 'nav-overlay';
document.body.appendChild(mobile_overlay);

mobileNavToggle.addEventListener('click', () => {
    navItems.classList.toggle('active');
    const icon = mobileNavToggle.querySelector('i');
    icon.classList.toggle('uil-bars');
    icon.classList.toggle('uil-times');
    mobile_overlay.classList.toggle('active');
});

// Close mobile menu when clicking outside
document.addEventListener('click', (e) => {
    if (!navItems.contains(e.target) &&
        !mobileNavToggle.contains(e.target) &&
        navItems.classList.contains('active')) {
        navItems.classList.remove('active');
        const icon = mobileNavToggle.querySelector('i');
        icon.classList.remove('uil-times');
        icon.classList.add('uil-bars');
        mobile_overlay.classList.remove('active');
    }
});
// Dashboard sidebar toggle
const showSidebarBtn = document.querySelector('#show__sidebar-btn');
const hideSidebarBtn = document.querySelector('#hide__sidebar-btn');
const sidebar = document.querySelector('.dashboard aside');
let sidebarState = localStorage.getItem('sidebarState') === 'open';

// Create overlay element
const overlay = document.createElement('div');
overlay.className = 'sidebar-overlay';
document.body.appendChild(overlay);

function openSidebar() {
    sidebar.classList.add('show');
    overlay.classList.add('show');
    showSidebarBtn.style.display = 'none';
    hideSidebarBtn.style.display = 'flex';
    localStorage.setItem('sidebarState', 'open');

    // Focus on first interactive element in sidebar
    const firstLink = sidebar.querySelector('a');
    if (firstLink) firstLink.focus();
}

function closeSidebar() {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
    showSidebarBtn.style.display = 'flex';
    hideSidebarBtn.style.display = 'none';
    localStorage.setItem('sidebarState', 'closed');
}

// Initialize sidebar state
if (sidebarState && window.innerWidth >= 992) {
    openSidebar();
}

if (showSidebarBtn) {
    showSidebarBtn.addEventListener('click', openSidebar);
}

if (hideSidebarBtn) {
    hideSidebarBtn.addEventListener('click', closeSidebar);
}

// Handle overlay click
overlay.addEventListener('click', closeSidebar);

// Handle keyboard navigation
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && sidebar.classList.contains('show')) {
        closeSidebar();
    }
});

// Update sidebar state on window resize
let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        if (window.innerWidth >= 992) {
            overlay.classList.remove('show');
        }
    }, 250);
});

// Close sidebar when clicking outside
document.addEventListener('click', (e) => {
    if (window.innerWidth < 992) {
        if (!sidebar.contains(e.target) &&
            !showSidebarBtn.contains(e.target) &&
            !hideSidebarBtn.contains(e.target)) {
            closeSidebar();
        }
    }
});
// chat bot
document.addEventListener('DOMContentLoaded', function () {

    let conversationContext = {
        lastCategory: null
    };
    // Add this at the top of your chatbot code
    const botResponses = {
        greeting: {
            keywords: ['مرحبا', 'السلام', 'اهلا', 'صباح الخير', 'مساء الخير'],
            responses: [
                'مرحباً بك في نبتة! كيف يمكنني مساعدتك اليوم؟ نقدم استشارات زوجية وأسرية متخصصة',
                'أهلاً بك! هل تبحث عن استشارة متخصصة أم معلومات عن مراحل تطور الأسرة؟'
            ]
        },
        marriage_prep: {
            keywords: ['خطوبة', 'زواج', 'مقبل', 'عريس', 'عروس', 'قبل الزواج'],
            responses: [
                'مرحلة ما قبل الزواج مهمة جداً! يمكنك الاطلاع على نصائح وإرشادات مفيدة في <a href="stage1.html">قسم ما قبل الزواج</a>',
                'نقدم استشارات متخصصة للمقبلين على الزواج. تصفح <a href="stage1.html#v4">قائمة مستشارينا</a>'
            ]
        },
        family_issues: {
            keywords: ['مشكلة', 'خلاف', 'صعوبة', 'زوجية', 'عائلية'],
            responses: [
                'يمكنك التحدث مع أحد مستشارينا المتخصصين في حل المشكلات الزوجية. <a href="consultations.php">احجز استشارة الآن</a>',
                'نحن هنا لمساعدتك. خبراؤنا متخصصون في حل المشكلات الأسرية. <a href="consultations.php#experts-section">اختر مستشارك</a>'
            ]
        },
        children: {
            keywords: ['طفل', 'اطفال', 'ابن', 'ابناء', 'تربية', 'مراهق'],
            responses: [
                'نقدم نصائح وإرشادات متخصصة في تربية الأطفال والمراهقين. زر <a href="stage3.html">قسم مرحلة الأبناء</a>',
                'هل تواجه تحديات في تربية أطفالك؟ استشر خبراءنا المتخصصين في التربية والأسرة'
            ]
        },
        courses: {
            keywords: ['دورة', 'تدريب', 'تعلم', 'ورشة'],
            responses: [
                'نقدم دورات متخصصة في التطوير الأسري والزوجي. <a href="courses.php">تصفح دوراتنا</a>',
                'اكتسب مهارات جديدة مع دوراتنا التدريبية المتخصصة. <a href="courses.php">اكتشف الدورات المتاحة</a>'
            ]
        },
        psychological: {
            keywords: ['نفسي', 'اكتئاب', 'قلق', 'توتر', 'ضغط'],
            responses: [
                'الصحة النفسية مهمة جداً للحياة الأسرية. يمكنك استشارة متخصصينا النفسيين <a href="consultations.php">من هنا</a>',
                'نقدم دعماً نفسياً متخصصاً للأزواج والعائلات. تحدث مع مستشارينا المتخصصين <a href="consultations.php#experts-section">من هنا</a>'
            ]
        },
        community: {
            keywords: ['مجتمع', 'منتدى', 'تجارب', 'مشاركة'],
            responses: [
                'شارك تجاربك وتعلم من تجارب الآخرين في <a href="community.php">منتدى نبتة</a>',
                'انضم لمجتمعنا الداعم وشارك في النقاشات المفيدة. <a href="community.php">زر المنتدى</a>'
            ]
        }
    };
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
        addMessage(message, 'user-message');

        // Show typing indicator
        const typingIndicator = document.createElement('div');
        typingIndicator.className = 'typing-indicator';
        typingIndicator.innerHTML = '<span></span><span></span><span></span>';
        chatMessages.appendChild(typingIndicator);
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Process bot response
        setTimeout(() => {
            // Remove typing indicator
            typingIndicator.remove();
            // Get bot response
            let response = '';
            for (const [category, data] of Object.entries(botResponses)) {
                if (data.keywords.some(keyword => message.includes(keyword))) {
                    conversationContext.lastCategory = category; // Save category
                    response = getContextualResponse(category, data.responses);
                    break;
                }
            }

            // If no matching response found, use default
            if (!response) {
                if (conversationContext.lastCategory) {
                    response = getFollowUpQuestion(conversationContext.lastCategory);
                } else {
                    response = 'عذراً، لم أفهم سؤالك. هل يمكنك إعادة صياغته بطريقة أخرى؟';
                }
            }

            // Add bot response
            addMessage(response, 'bot-message');

            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }, 1000);
    }

    function addMessage(text, className) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${className}`;
        messageDiv.innerHTML = text;
        const links = messageDiv.getElementsByTagName('a');
        Array.from(links).forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                window.location.href = link.href;
            });
        });
        chatMessages.appendChild(messageDiv);
    }
    function getContextualResponse(category, responses) {
        const baseResponse = responses[Math.floor(Math.random() * responses.length)];

        // Add category-specific follow-up questions
        const followUps = {
            marriage_prep: 'هل تريد معرفة المزيد عن خدمات الاستشارة قبل الزواج؟',
            family_issues: 'هل ترغب في التحدث مع أحد مستشارينا؟',
            children: 'هل لديك أسئلة محددة عن تربية الأطفال؟',
            courses: 'هل تريد معرفة مواعيد الدورات القادمة؟',
            psychological: 'هل ترغب في حجز موعد مع مستشار نفسي؟'
        };

        return `${baseResponse}\n\n${followUps[category] || ''}`;
    }

    function getFollowUpQuestion(category) {
        const followUps = {
            marriage_prep: 'هل تحتاج إلى مزيد من المعلومات عن الاستشارات الزوجية؟',
            family_issues: 'هل هناك موضوع محدد تريد مناقشته مع مستشارينا؟',
            children: 'هل تواجه تحديات معينة في تربية أطفالك؟',
            courses: 'هل تبحث عن دورة معينة؟',
            psychological: 'هل ترغب في معرفة المزيد عن خدماتنا النفسية؟',
            community: 'هل ترغب في المشاركة في منتدى النقاش؟'
        };

        return followUps[category] || 'هل هناك شيء آخر يمكنني مساعدتك به؟';
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