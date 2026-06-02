// scripts/script.js

// GA4 interaction hooks
(() => {
  const sendEvent = (eventName, params = {}) => {
    if (!eventName || typeof window.gtag !== "function") return;
    window.gtag("event", eventName, params);
  };

  const datasetParams = (element) => {
    const params = {};
    Object.entries(element.dataset).forEach(([key, value]) => {
      if (!key.startsWith("analytics") || key === "analyticsEvent") return;
      const normalised = key
        .replace(/^analytics/, "")
        .replace(/^[A-Z]/, (letter) => letter.toLowerCase())
        .replace(/[A-Z]/g, (letter) => `_${letter.toLowerCase()}`);
      params[normalised] = value;
    });
    return params;
  };

  document.addEventListener("click", (event) => {
    const target = event.target.closest("[data-analytics-event]");
    if (!target) return;
    sendEvent(target.dataset.analyticsEvent, datasetParams(target));
  });

  document.querySelectorAll("form[data-form-type]").forEach((form) => {
    let started = false;
    const params = { form_type: form.dataset.formType || "contact", page_type: form.querySelector('[name="page_type"]')?.value || "" };
    form.addEventListener("input", () => {
      if (started) return;
      started = true;
      sendEvent("form_start", params);
    }, { once: true });
    form.addEventListener("submit", () => {
      sendEvent("form_submit", params);
    });
  });

  if ("IntersectionObserver" in window) {
    const observer = new IntersectionObserver((entries, currentObserver) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const target = entry.target;
        sendEvent(target.dataset.analyticsView, datasetParams(target));
        currentObserver.unobserve(target);
      });
    }, { threshold: 0.35 });
    document.querySelectorAll("[data-analytics-view]").forEach((target) => observer.observe(target));
  }
})();

// Mobile nav toggle
(() => {
  const btn = document.querySelector(".nav__toggle");
  const menu = document.getElementById("navMenu");
  if (!btn || !menu) return;

  const close = () => {
    menu.classList.remove("is-open");
    btn.classList.remove("is-open");
    btn.setAttribute("aria-expanded", "false");
    document.body.classList.remove("nav-open");
  };

  const toggle = () => {
    const open = menu.classList.toggle("is-open");
    btn.classList.toggle("is-open", open);
    btn.setAttribute("aria-expanded", open ? "true" : "false");
    document.body.classList.toggle("nav-open", open);
  };

  btn.addEventListener("click", (e) => {
    e.preventDefault();
    e.stopPropagation();
    toggle();
  });

  // close when clicking a link
  menu.querySelectorAll("a").forEach((a) => a.addEventListener("click", close));

  // close on outside click
  document.addEventListener("click", (e) => {
    if (!menu.classList.contains("is-open")) return;
    if (menu.contains(e.target) || btn.contains(e.target)) return;
    close();
  });

  // close on Escape
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") close();
  });
})();

// Scroll-to-reveal blocks
(() => {
  const autoRevealSelector = [
    "main .section__header",
    "main .hero .stack",
    "main .hero__media",
    "main .blog-hero .stack",
    "main .blog-hero__media",
    "main .article-header",
    "main .article-hero",
    "main .article-body > h2",
    "main .article-body > h3",
    "main .article-body > p",
    "main .article-cta",
    "main .card",
    "main .timeline__item",
    "main .tags",
    "main .program__item",
    "main .ribbon__item",
    "main .center.pad-top-m",
    "main .home-label",
    "main .pathway-visual",
    "main .alignment-visual",
    "main .system-card",
    "main .program-pathway",
    "main .price-snapshot",
    "main .proof-card",
    "main .teacher-preview",
    ".reveal-block",
  ].join(",");

  let didInitRevealBlocks = false;

  const initRevealBlocks = () => {
    if (didInitRevealBlocks) return;

    const blocks = Array.from(new Set(document.querySelectorAll(autoRevealSelector)))
      .filter((block) => !block.closest(".site-header, .site-footer"));

    if (!blocks.length) return;
    didInitRevealBlocks = true;

    if (!("IntersectionObserver" in window)) {
      blocks.forEach((block) => block.classList.add("is-revealed"));
      return;
    }

    blocks.forEach((block) => block.classList.add("reveal-block", "is-reveal-ready"));

    const revealQueue = [];
    const queuedBlocks = new Set();
    let revealFrame = null;

    const flushRevealQueue = () => {
      revealFrame = null;

      const visibleBlocks = revealQueue
        .splice(0)
        .sort(
          (a, b) =>
            a.getBoundingClientRect().top - b.getBoundingClientRect().top ||
            a.getBoundingClientRect().left - b.getBoundingClientRect().left
        );

      visibleBlocks.forEach((block, index) => {
        queuedBlocks.delete(block);
        block.style.setProperty("--reveal-delay", `${index * 0.1}s`);
        block.classList.add("is-revealed");
      });
    };

    const observer = new IntersectionObserver(
      (entries, currentObserver) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;

          const block = entry.target;
          if (!queuedBlocks.has(block)) {
            queuedBlocks.add(block);
            revealQueue.push(block);
          }
          currentObserver.unobserve(block);
        });

        if (revealQueue.length && !revealFrame) {
          revealFrame = window.requestAnimationFrame(flushRevealQueue);
        }
      },
      {
        threshold: 0.18,
        rootMargin: "0px 0px -8% 0px",
      }
    );

    blocks.forEach((block) => observer.observe(block));
  };

  initRevealBlocks();
  document.addEventListener("DOMContentLoaded", initRevealBlocks, { once: true });
})();

// Theme toggle (2-state: light <-> dark)
(() => {
  const btn = document.getElementById("themeToggle");
  if (!btn) return;

  const KEY = "theme"; // stores: "light" or "dark"
  let userSet = false;

  const apply = (mode) => {
    document.body.classList.remove("theme-dark", "theme-light");
    document.body.classList.add(mode === "light" ? "theme-light" : "theme-dark");

    // aria-pressed: true = "active" (useful for screen readers)
    btn.setAttribute("aria-pressed", mode === "dark" ? "true" : "false");

    // helps native form controls match
    document.documentElement.style.colorScheme = mode;
  };

  // initial mode: saved > system preference
  const saved = localStorage.getItem(KEY);
  userSet = saved === "light" || saved === "dark";
  const systemDark =
    window.matchMedia &&
    window.matchMedia("(prefers-color-scheme: dark)").matches;

  const initial =
    saved === "light" || saved === "dark"
      ? saved
      : systemDark
      ? "dark"
      : "light";

  apply(initial);

  // react to system changes if user hasn't set a manual preference yet
  if (!userSet && window.matchMedia) {
    const mq = window.matchMedia("(prefers-color-scheme: dark)");
    mq.addEventListener("change", (e) => {
      if (userSet) return;
      apply(e.matches ? "dark" : "light");
    });
  }

  btn.addEventListener("click", () => {
    const next = document.body.classList.contains("theme-dark") ? "light" : "dark";
    userSet = true;
    localStorage.setItem(KEY, next);
    apply(next);
  });
})();

// Language preference and multilingual localisation
(() => {
  const STORAGE_KEY = "languagePreference"; // stores: "auto", "en", "vi", or "zh"
  const SUPPORTED = new Set(["auto", "en", "vi", "zh"]);

  const translations = {
    vi: {
      strings: {
        "Menu": "Menu",
        "Home": "Trang chủ",
        "About": "Giới thiệu",
        "Teacher": "Giáo viên",
        "Lessons": "Bài học",
        "Results": "Kết quả",
        "Initial Assessment": "Đánh giá ban đầu",
        "Programs": "Chương trình",
        "Blog": "Blog",
        "Contact": "Liên hệ",
        "FAQ": "Câu hỏi thường gặp",
        "Privacy Policy": "Chính sách quyền riêng tư",
        "Book Initial Assessment": "Đặt lịch đánh giá ban đầu",
        "View Programs": "Xem chương trình",
        "Read more about the teacher": "Đọc thêm về giáo viên",
        "Structured piano lessons": "Lớp piano có lộ trình rõ ràng",
        "Developing confidence, discipline, musical understanding, and long-term progress through guided one-on-one learning. Suitable for beginners, experienced, and exam-focused students who need clear direction and caring support.": "Phát triển sự tự tin, kỷ luật, hiểu biết âm nhạc và tiến bộ lâu dài qua hình thức học một-kèm-một có hướng dẫn. Phù hợp với học viên mới bắt đầu, đã có kinh nghiệm hoặc đang chuẩn bị thi cần định hướng rõ ràng và sự hỗ trợ tận tâm.",
        "Piano for the Ambitious": "Piano cho học viên có mục tiêu",
        "Structured One-on-One Learning": "Học một-kèm-một có cấu trúc",
        "5.0 ★ on Google": "5,0 ★ trên Google",
        "Meet Liana, Your Teacher": "Gặp Liana, giáo viên của bạn",
        "Origins": "Khởi đầu",
        "Liana trained through a structured Russian conservatory pathway, building deep technical and musical foundations from an early stage. She has participated in and won multiple local and international competitions in Moscow, achieving titles like laureate and diplomant.": "Liana được đào tạo theo lộ trình âm nhạc Nga bài bản, xây dựng nền tảng kỹ thuật và âm nhạc vững chắc từ sớm. Cô từng tham gia và đạt giải trong nhiều cuộc thi địa phương và quốc tế tại Moscow.",
        "Sydney Chapter": "Chặng đường tại Sydney",
        "She now teaches children, teens, and adults in Wentworth Point, combining AMEB-aligned structure with warm, child-responsive teaching.": "Hiện cô giảng dạy trẻ em, thiếu niên và người lớn tại Wentworth Point, kết hợp lộ trình theo AMEB với phương pháp ấm áp, phù hợp từng học viên.",
        "Today": "Hiện nay",
        "Today, Fortepiano Academy supports families from Wentworth Point, Rhodes, Sydney Olympic Park, Newington, Homebush, Lidcombe, and surrounding suburbs with clear plans, progress tracking, and performance culture.": "Hiện nay, Fortepiano Academy hỗ trợ các gia đình ở Wentworth Point, Rhodes, Sydney Olympic Park, Newington, Homebush, Lidcombe và vùng lân cận bằng kế hoạch rõ ràng, theo dõi tiến bộ và văn hóa biểu diễn.",
        "Posture · Technique · Rhythm · Reading": "Tư thế · Kỹ thuật · Nhịp điệu · Đọc nhạc",
        "AMEB-aligned progression": "Tiến trình theo AMEB",
        "WWCC / child-safe professionalism": "WWCC / môi trường chuyên nghiệp an toàn cho trẻ",
        "Inside the lessons": "Bên trong các buổi học",
        "A proven system for growth.": "Một hệ thống đã được chứng minh giúp học viên phát triển.",
        "Structured Term Plans": "Kế hoạch học kỳ có cấu trúc",
        "Each grade achievable in half a year.": "Mỗi cấp độ có thể đạt được trong nửa năm.",
        "Diaries & Reports": "Nhật ký và báo cáo",
        "Detailed diary entries and progress tracking.": "Ghi chép nhật ký chi tiết và theo dõi tiến bộ.",
        "Exam Pathways": "Lộ trình thi",
        "AMEB preparation with mock exams & milestones.": "Chuẩn bị AMEB với thi thử và các mốc tiến độ.",
        "Performances & Community": "Biểu diễn và cộng đồng",
        "Recitals and workshops for shared learning.": "Recital và workshop để cùng học hỏi.",
        "Fortepiano Academy is a good fit if your child…": "Fortepiano Academy phù hợp nếu con bạn…",
        "enjoys music but needs structure and weekly direction": "yêu âm nhạc nhưng cần cấu trúc và định hướng hằng tuần",
        "is shy, thoughtful, or needs patient one-on-one guidance": "nhút nhát, sâu sắc hoặc cần hướng dẫn một-kèm-một kiên nhẫn",
        "struggles to stay focused in group lesson settings": "khó tập trung trong lớp nhóm",
        "benefits from a calm, consistent teacher relationship": "cần mối quan hệ học tập bình tĩnh và nhất quán với giáo viên",
        "wants strong foundations in posture, rhythm, reading, and technique": "muốn nền tảng vững về tư thế, nhịp, đọc nhạc và kỹ thuật",
        "is preparing for AMEB exams or future graded progress": "đang chuẩn bị thi AMEB hoặc muốn tiến lên các cấp độ",
        "needs accountability with practice diaries and progress tracking": "cần trách nhiệm học tập qua nhật ký luyện tập và theo dõi tiến bộ",
        "is ready for serious progress without losing the joy of music": "sẵn sàng tiến bộ nghiêm túc mà vẫn giữ niềm vui âm nhạc",
        "Gallery": "Thư viện ảnh",
        "Recitals · Lessons · Progress Moments": "Recital · Buổi học · Khoảnh khắc tiến bộ",
        "Focused and guided learning": "Học tập tập trung và có hướng dẫn",
        "Extensive exam preparation": "Chuẩn bị thi toàn diện",
        "Supportive and friendly environment for all": "Môi trường hỗ trợ và thân thiện cho mọi học viên",
        "Student Success Stories": "Câu chuyện thành công của học viên",
        "Achievements shaped by clarity, consistency and structured growth.": "Thành tựu được hình thành từ sự rõ ràng, nhất quán và phát triển có cấu trúc.",
        "Starting is simple": "Bắt đầu rất đơn giản",
        "1) Book an Initial Assessment ($40).": "1) Đặt lịch đánh giá ban đầu ($40).",
        "2) We gently evaluate": "2) Chúng tôi nhẹ nhàng đánh giá",
        "level, learning style, focus, rhythm, reading, posture, and readiness.": "trình độ, phong cách học, sự tập trung, nhịp, đọc nhạc, tư thế và mức độ sẵn sàng.",
        "3) You receive a suitable program recommendation": "3) Bạn nhận được đề xuất chương trình phù hợp",
        "based on your child’s needs and goals.": "dựa trên nhu cầu và mục tiêu của con bạn.",
        "4) Lessons begin with a clear plan": "4) Buổi học bắt đầu với kế hoạch rõ ràng",
        ", weekly guidance, and ongoing progress tracking.": ", hướng dẫn hằng tuần và theo dõi tiến bộ liên tục.",
        "Program Setup ($80) applies only if continuing, when an individual term plan is prepared.": "Phí thiết lập chương trình ($80) chỉ áp dụng khi tiếp tục học và khi kế hoạch học kỳ cá nhân được chuẩn bị.",
        "How the Fortepiano System Works": "Hệ thống Fortepiano hoạt động như thế nào",
        "Assessment → Term Planning → Progress Tracking → Exam/Recital": "Đánh giá → Lập kế hoạch học kỳ → Theo dõi tiến bộ → Thi/Recital",
        "Every journey begins with an assessment lesson to evaluate skills and goals. The teacher then recommends the most suitable program pathway.": "Mỗi hành trình bắt đầu bằng buổi đánh giá kỹ năng và mục tiêu. Sau đó giáo viên đề xuất lộ trình chương trình phù hợp nhất.",
        "Download the guide and discover how Fortepiano Academy turns lessons into lasting success — built upon years of teaching and student achievement.": "Tải hướng dẫn để khám phá cách Fortepiano Academy biến các buổi học thành thành công bền vững — dựa trên nhiều năm giảng dạy và thành tựu học viên.",
        "Some students begin with one lesson per week, while others follow a more supported pathway with stronger accountability and AMEB preparation. All students begin with an Initial Assessment and are placed into the program best suited to their goals.": "Một số học viên bắt đầu với một buổi mỗi tuần, trong khi những em khác theo lộ trình được hỗ trợ nhiều hơn với trách nhiệm học tập cao hơn và chuẩn bị AMEB. Tất cả học viên bắt đầu bằng Đánh giá ban đầu và được xếp vào chương trình phù hợp nhất với mục tiêu.",
        "Tuition is billed monthly in advance. Standard lesson rates are reference only; lessons are offered through structured programs rather than casual bookings.": "Học phí được thanh toán trước theo tháng. Mức phí buổi học tiêu chuẩn chỉ để tham khảo; các buổi học được cung cấp qua chương trình có cấu trúc thay vì đặt lịch rời rạc.",
        "Foundation": "Nền tảng",
        "A steady pathway for families who can support regular practice at home.": "Lộ trình ổn định cho gia đình có thể hỗ trợ luyện tập đều đặn tại nhà.",
        "FORMAT": "HÌNH THỨC",
        "1 lesson per week": "1 buổi mỗi tuần",
        "BEST FOR": "PHÙ HỢP VỚI",
        "Casual learners": "Học viên học nhẹ nhàng",
        "Families with tighter schedules": "Gia đình có lịch trình bận rộn",
        "Students progressing at a relaxed pace": "Học viên tiến bộ với nhịp độ thoải mái",
        "INCLUDES": "BAO GỒM",
        "Weekly practice diary": "Nhật ký luyện tập hằng tuần",
        "Term-based learning plan": "Kế hoạch học theo học kỳ",
        "Participation in studio recitals": "Tham gia recital của studio",
        "Limited support outside lesson hours": "Hỗ trợ giới hạn ngoài giờ học",
        "SUMMARY": "TÓM TẮT",
        "A stable entry point into piano study, ideal for families seeking steadiness. Maximum flexibility, but much greater reliance on consistent home practice.": "Điểm khởi đầu ổn định cho việc học piano, lý tưởng cho gia đình muốn sự đều đặn. Linh hoạt tối đa nhưng phụ thuộc nhiều hơn vào luyện tập nhất quán tại nhà.",
        "Development": "Phát triển",
        "Recommended": "Được khuyến nghị",
        "The core structured pathway for stronger progress, regular guidance, and AMEB readiness.": "Lộ trình cấu trúc cốt lõi để tiến bộ mạnh hơn, được hướng dẫn thường xuyên và sẵn sàng cho AMEB.",
        "2 lessons per week": "2 buổi mỗi tuần",
        "Exam-oriented students": "Học viên định hướng thi",
        "Families seeking predictable, measurable progress": "Gia đình muốn tiến bộ rõ ràng và đo lường được",
        "Students aiming to complete grades efficiently": "Học viên muốn hoàn thành cấp độ hiệu quả",
        "Everything in Foundation, plus:": "Tất cả trong Nền tảng, cộng thêm:",
        "Two weekly lessons (with frequency-based value)": "Hai buổi học mỗi tuần (giá trị theo tần suất)",
        "Monthly progress reports": "Báo cáo tiến bộ hằng tháng",
        "Structured AMEB exam preparation": "Chuẩn bị thi AMEB có cấu trúc",
        "Mock exams and readiness checks": "Thi thử và kiểm tra mức độ sẵn sàng",
        "Teacher-managed AMEB enrolments and exam fees covered by the academy": "Giáo viên quản lý đăng ký AMEB và học viện chi trả lệ phí thi",
        "Outside-lesson support on demand (text/video support upon discussion and availability)": "Hỗ trợ ngoài giờ học khi cần (tin nhắn/video tùy trao đổi và lịch trống)",
        "The most comprehensive and recommended pathway for serious students and families who value structure, oversight, and consistency.": "Lộ trình toàn diện và được khuyến nghị nhất cho học viên nghiêm túc và gia đình coi trọng cấu trúc, sự theo sát và tính nhất quán.",
        "Start Your Journey": "Bắt đầu hành trình của bạn",
        "Fill in the form and we’ll arrange your first lesson.": "Điền vào biểu mẫu và chúng tôi sẽ sắp xếp buổi học đầu tiên.",
        "Name": "Tên",
        "Phone / Email": "Điện thoại / Email",
        "Child’s Age / Level": "Tuổi / trình độ của trẻ",
        "Message": "Tin nhắn",
        "Send": "Gửi",
        "By submitting this form, you agree to our": "Bằng cách gửi biểu mẫu này, bạn đồng ý với",
        ".": ".",
        "Frequently Asked Questions": "Câu hỏi thường gặp",
        "When can students start lessons?": "Học viên có thể bắt đầu khi nào?",
        "Students can start at any time during the year. Fortepiano Academy operates on rolling enrolment rather than fixed school terms. Each student is placed into the appropriate level and program cycle based on their ability and goals.": "Học viên có thể bắt đầu bất cứ lúc nào trong năm. Fortepiano Academy tuyển sinh liên tục thay vì theo học kỳ cố định. Mỗi học viên được xếp vào cấp độ và chu kỳ chương trình phù hợp dựa trên năng lực và mục tiêu.",
        "Is the program tied to school terms?": "Chương trình có phụ thuộc học kỳ trường không?",
        "No. Programs are grade-based rather than calendar-based. This allows students to begin when they are ready and progress without being restricted by school term dates.": "Không. Chương trình dựa trên cấp độ thay vì lịch học kỳ. Điều này cho phép học viên bắt đầu khi sẵn sàng và tiến bộ mà không bị giới hạn bởi ngày học kỳ.",
        "How do AMEB exams fit into the program?": "Kỳ thi AMEB được đưa vào chương trình như thế nào?",
        "AMEB exam preparation is integrated into the curriculum for students following an examination pathway. Preparation begins well in advance, ensuring students are confident and ready regardless of the final exam date allocated by AMEB.": "Việc chuẩn bị thi AMEB được tích hợp vào chương trình cho học viên theo lộ trình thi. Quá trình chuẩn bị bắt đầu sớm để học viên tự tin và sẵn sàng bất kể ngày thi cuối cùng do AMEB phân bổ.",
        "Does my child have to do an exam?": "Con tôi có bắt buộc phải thi không?",
        "No. AMEB exams are optional. Students may follow an exam pathway or focus on musicianship, technique, repertoire, and performance without sitting formal examinations.": "Không. Kỳ thi AMEB là tùy chọn. Học viên có thể theo lộ trình thi hoặc tập trung vào nhạc cảm, kỹ thuật, tác phẩm và biểu diễn mà không thi chính thức.",
        "How is lesson length decided?": "Thời lượng buổi học được quyết định như thế nào?",
        "Lesson length is determined after an initial assessment, based on the student’s age, level, learning pace, and goals. As students progress, lesson length may increase to ensure sufficient time for technical work and repertoire.": "Thời lượng buổi học được quyết định sau đánh giá ban đầu, dựa trên tuổi, trình độ, tốc độ học và mục tiêu của học viên. Khi học viên tiến bộ, thời lượng có thể tăng để có đủ thời gian cho kỹ thuật và tác phẩm.",
        "What makes Fortepiano Academy different?": "Điều gì làm Fortepiano Academy khác biệt?",
        "Fortepiano Academy offers structured programs with clear progression, disciplined technical training influenced by Russian pedagogy, regular progress tracking, and a supportive learning environment combined with the flexibility of the AMEB syllabus.": "Fortepiano Academy cung cấp chương trình có cấu trúc với tiến trình rõ ràng, rèn luyện kỹ thuật kỷ luật chịu ảnh hưởng phương pháp Nga, theo dõi tiến bộ thường xuyên và môi trường học hỗ trợ kết hợp sự linh hoạt của giáo trình AMEB.",
        "How do I enrol myself or my child in piano lessons?": "Tôi đăng ký học piano cho mình hoặc cho con như thế nào?",
        "Enrolment begins with a short conversation via call or message to discuss the student’s age, experience, goals, and availability. An initial assessment lesson is then booked.": "Việc đăng ký bắt đầu bằng cuộc trao đổi ngắn qua cuộc gọi hoặc tin nhắn về tuổi, kinh nghiệm, mục tiêu và lịch trống của học viên. Sau đó sẽ đặt buổi đánh giá ban đầu.",
        "At what age can my child start piano lessons?": "Con tôi có thể bắt đầu học piano từ tuổi nào?",
        "Children can begin lessons from around 4 years old, depending on their focus, coordination, and readiness. Piano lessons also support the development of concentration, listening skills, and fine motor control.": "Trẻ có thể bắt đầu học từ khoảng 4 tuổi, tùy khả năng tập trung, phối hợp và mức độ sẵn sàng. Học piano cũng hỗ trợ phát triển sự tập trung, kỹ năng lắng nghe và vận động tinh.",
        "Do you prepare students for performances and exams?": "Bạn có chuẩn bị học viên cho biểu diễn và kỳ thi không?",
        "Yes. Students are encouraged to participate in studio performances, recitals, and AMEB examinations.": "Có. Học viên được khuyến khích tham gia biểu diễn tại studio, recital và kỳ thi AMEB.",
        "What if my child has a busy schedule with other activities?": "Nếu con tôi bận với các hoạt động khác thì sao?",
        "Flexible scheduling is available where possible. For busy students, more frequent lessons are often recommended, as they reduce reliance on long independent practice sessions and help maintain steady progress.": "Có thể sắp xếp lịch linh hoạt khi điều kiện cho phép. Với học viên bận rộn, thường khuyến nghị học thường xuyên hơn vì điều này giảm phụ thuộc vào các buổi tự luyện dài và giúp duy trì tiến bộ ổn định.",
        "How often should lessons be scheduled, and how much practice is required?": "Nên học bao lâu một lần và cần luyện tập bao nhiêu?",
        "Twice-weekly lessons are recommended for optimal progress. Practice expectations vary by level:": "Khuyến nghị học hai buổi mỗi tuần để đạt tiến bộ tối ưu. Thời lượng luyện tập tùy theo trình độ:",
        "Beginners: approximately 10–20 minutes per day": "Người mới bắt đầu: khoảng 10–20 phút mỗi ngày",
        "Intermediate to advanced students: approximately 40–60 minutes per day": "Học viên trung cấp đến nâng cao: khoảng 40–60 phút mỗi ngày",
        "Consistent practice is essential for meaningful progress.": "Luyện tập nhất quán là yếu tố thiết yếu để tiến bộ thực sự.",
        "What is your cancellation policy?": "Chính sách hủy lịch là gì?",
        "Cancellations are requested with at least 24 hours’ notice wherever possible. Each student has one charge-free cancellation per term, usable even with late notice. After this is used, cancellations with 24 hours’ notice are eligible for a make-up lesson or credit (subject to availability). Day-of cancellations and no-shows are forfeited. Make-ups and credits must be used within the same term and cannot be carried over.": "Vui lòng báo hủy trước ít nhất 24 giờ khi có thể. Mỗi học viên có một lần hủy không tính phí mỗi kỳ, có thể dùng cả khi báo trễ. Sau khi đã dùng, các lần hủy có báo trước 24 giờ có thể được học bù hoặc ghi có (tùy lịch trống). Hủy trong ngày và vắng mặt không báo sẽ bị mất buổi. Buổi học bù và tín dụng phải dùng trong cùng kỳ và không được chuyển sang kỳ sau.",
        "Fortepiano Academy": "Fortepiano Academy",
        "WWCC · Public Liability · Creative Kids Provider": "WWCC · Bảo hiểm trách nhiệm công cộng · Nhà cung cấp Creative Kids",
        "Principal Teacher": "Giáo viên chính",
        "Meet Liana": "Gặp Liana",
        "Russian-trained piano teacher in Wentworth Point": "Giáo viên piano được đào tạo theo trường phái Nga tại Wentworth Point",
        "Read Full Profile": "Đọc hồ sơ đầy đủ",
        "Founder and Principal Piano Teacher of Fortepiano Academy": "Nhà sáng lập và giáo viên piano chính của Fortepiano Academy",
        "Moscow Training": "Đào tạo tại Moscow",
        "A Russian Music-School Foundation": "Nền tảng trường âm nhạc Nga",
        "Music Subjects Completed": "Các môn âm nhạc đã hoàn thành",
        "Piano": "Piano",
        "Piano Performance": "Biểu diễn piano",
        "Solfeggio": "Xướng âm",
        "Music Literature": "Văn học âm nhạc",
        "Choir": "Hợp xướng",
        "Early Achievement and Performance Background": "Thành tích ban đầu và nền tảng biểu diễn",
        "Her award records include:": "Các thành tích giải thưởng gồm:",
        "Teaching Philosophy": "Triết lý giảng dạy",
        "Structured, Warm, and Serious About Progress": "Có cấu trúc, ấm áp và nghiêm túc về tiến bộ",
        "What Students Learn": "Học viên học được gì",
        "Why Families Choose This Approach": "Vì sao các gia đình chọn phương pháp này",
        "Ready to begin?": "Sẵn sàng bắt đầu?",
        "Blog posts, handwritten, sourced from years of experience": "Các bài blog được viết từ nhiều năm kinh nghiệm",
        "Dive deeper into the topics of piano lessons and music.": "Tìm hiểu sâu hơn về chủ đề học piano và âm nhạc.",
        "Latest Articles": "Bài viết mới nhất",
        "What Is the Best Age to Start Piano Lessons for Your Child?": "Độ tuổi tốt nhất để con bạn bắt đầu học piano là khi nào?",
        "A practical guide for families deciding whether their child is ready for structured piano lessons.": "Hướng dẫn thực tế cho gia đình đang cân nhắc liệu con đã sẵn sàng học piano có cấu trúc hay chưa.",
        "Read Article": "Đọc bài viết",
        "Piano lesson advice for families in Wentworth Point and surrounding Sydney suburbs.": "Lời khuyên học piano cho gia đình ở Wentworth Point và các vùng lân cận Sydney.",
        "Thinking about piano lessons for your child?": "Bạn đang nghĩ đến việc cho con học piano?",
        "An initial assessment can help decide whether your child is ready and what lesson structure will suit them best.": "Buổi đánh giá ban đầu có thể giúp xác định con bạn đã sẵn sàng chưa và cấu trúc buổi học nào phù hợp nhất.",
        "Privacy Policy for Fortepiano Academy": "Chính sách quyền riêng tư của Fortepiano Academy",
        "Last updated: 2025": "Cập nhật lần cuối: 2025",
        "Information We Collect": "Thông tin chúng tôi thu thập",
        "How We Use Information": "Cách chúng tôi sử dụng thông tin",
        "Contact Us": "Liên hệ với chúng tôi"
      },
      attrs: {
        "Toggle navigation": "Mở/đóng điều hướng",
        "Toggle theme": "Chuyển giao diện",
        "Fortepiano Academy home": "Trang chủ Fortepiano Academy",
        "Fortepiano Academy logo dark": "Logo Fortepiano Academy phiên bản tối",
        "Fortepiano Academy logo light": "Logo Fortepiano Academy phiên bản sáng",
        "Teacher and student at the piano": "Giáo viên và học viên bên đàn piano",
        "Piano Lessons Wentworth Point | Fortepiano Academy": "Lớp piano Wentworth Point | Fortepiano Academy",
        "Principal Piano Teacher | Liana | Fortepiano Academy": "Giáo viên piano chính | Liana | Fortepiano Academy",
        "Piano Lessons Blog | Fortepiano Academy Wentworth Point": "Blog lớp piano | Fortepiano Academy Wentworth Point",
        "Best Age to Start Piano Lessons for Kids | Fortepiano Academy": "Độ tuổi tốt nhất để trẻ bắt đầu học piano | Fortepiano Academy",
        "Structured one-on-one piano lessons for children and teens in Wentworth Point. Build confidence, technique, musical understanding, and AMEB-ready progress through guided private lessons.": "Lớp piano một-kèm-một có cấu trúc cho trẻ em và thiếu niên tại Wentworth Point. Xây dựng sự tự tin, kỹ thuật, hiểu biết âm nhạc và tiến bộ sẵn sàng cho AMEB qua các buổi học riêng có hướng dẫn."
      }
    },
    zh: {
          "strings": {
                "Menu": "菜单",
                "Home": "首页",
                "About": "关于",
                "Teacher": "教师",
                "Lessons": "课程",
                "Results": "成果",
                "Initial Assessment": "初次评估",
                "Programs": "课程方案",
                "Blog": "博客",
                "Contact": "联系",
                "FAQ": "常见问题",
                "Privacy Policy": "隐私政策",
                "Book Initial Assessment": "预约初次评估",
                "View Programs": "查看课程方案",
                "Read more about the teacher": "了解教师详情",
                "Structured piano lessons": "系统化钢琴课程",
                "Developing confidence, discipline, musical understanding, and long-term progress through guided one-on-one learning. Suitable for beginners, experienced, and exam-focused students who need clear direction and caring support.": "通过有指导的一对一学习，培养自信、自律、音乐理解力和长期进步。适合初学者、有经验的学生，以及需要清晰方向和细心支持的备考学生。",
                "Piano for the Ambitious": "为有目标的学生而设的钢琴学习",
                "Structured One-on-One Learning": "系统化一对一学习",
                "5.0 ★ on Google": "Google 5.0 ★ 评分",
                "Meet Liana, Your Teacher": "认识您的教师 Liana",
                "Origins": "起点",
                "Liana trained through a structured Russian conservatory pathway, building deep technical and musical foundations from an early stage. She has participated in and won multiple local and international competitions in Moscow, achieving titles like laureate and diplomant.": "Liana 接受过系统的俄罗斯音乐学院式训练，从早期开始建立深厚的技巧与音乐基础。她曾在莫斯科参加并赢得多项本地及国际比赛，获得获奖者和荣誉证书等称号。",
                "Sydney Chapter": "悉尼篇章",
                "She now teaches children, teens, and adults in Wentworth Point, combining AMEB-aligned structure with warm, child-responsive teaching.": "她现在在 Wentworth Point 教授儿童、青少年和成人，将符合 AMEB 方向的系统训练与温暖、回应孩子需求的教学结合起来。",
                "Today": "今天",
                "Today, Fortepiano Academy supports families from Wentworth Point, Rhodes, Sydney Olympic Park, Newington, Homebush, Lidcombe, and surrounding suburbs with clear plans, progress tracking, and performance culture.": "如今，Fortepiano Academy 通过清晰计划、进度跟踪和表演文化，支持来自 Wentworth Point、Rhodes、Sydney Olympic Park、Newington、Homebush、Lidcombe 及周边社区的家庭。",
                "Posture · Technique · Rhythm · Reading": "姿势 · 技巧 · 节奏 · 读谱",
                "AMEB-aligned progression": "符合 AMEB 方向的进阶路径",
                "WWCC / child-safe professionalism": "WWCC / 儿童安全专业标准",
                "Inside the lessons": "课程内容",
                "A proven system for growth.": "经过验证的成长体系。",
                "Structured Term Plans": "系统化学期计划",
                "Each grade achievable in half a year.": "每个级别可在半年内达成。",
                "Diaries & Reports": "练习日记与报告",
                "Detailed diary entries and progress tracking.": "详细练习记录和进度跟踪。",
                "Exam Pathways": "考试路径",
                "AMEB preparation with mock exams & milestones.": "通过模拟考试和阶段目标准备 AMEB。",
                "Performances & Community": "表演与社区",
                "Recitals and workshops for shared learning.": "通过音乐会和工作坊共同学习。",
                "Fortepiano Academy is a good fit if your child…": "如果您的孩子符合以下情况，Fortepiano Academy 会很适合…",
                "enjoys music but needs structure and weekly direction": "喜欢音乐，但需要结构和每周指导",
                "is shy, thoughtful, or needs patient one-on-one guidance": "性格害羞、细腻，或需要耐心的一对一指导",
                "struggles to stay focused in group lesson settings": "在小组课环境中难以保持专注",
                "benefits from a calm, consistent teacher relationship": "能从平静、稳定的师生关系中受益",
                "wants strong foundations in posture, rhythm, reading, and technique": "希望在姿势、节奏、读谱和技巧方面打下坚实基础",
                "is preparing for AMEB exams or future graded progress": "正在准备 AMEB 考试或未来级别进阶",
                "needs accountability with practice diaries and progress tracking": "需要通过练习日记和进度跟踪建立责任感",
                "is ready for serious progress without losing the joy of music": "准备认真进步，同时不失去音乐的乐趣",
                "Gallery": "相册",
                "Recitals · Lessons · Progress Moments": "音乐会 · 课程 · 进步瞬间",
                "Focused and guided learning": "专注且有指导的学习",
                "Extensive exam preparation": "全面考试准备",
                "Supportive and friendly environment for all": "面向所有学生的支持性友好环境",
                "Student Success Stories": "学生成功故事",
                "Achievements shaped by clarity, consistency and structured growth.": "成就来自清晰、持续和系统化成长。",
                "Starting is simple": "开始很简单",
                "1) Book an Initial Assessment ($40).": "1）预约初次评估（$40）。",
                "2) We gently evaluate": "2）我们会温和地评估",
                "level, learning style, focus, rhythm, reading, posture, and readiness.": "水平、学习方式、专注力、节奏、读谱、姿势和准备程度。",
                "3) You receive a suitable program recommendation": "3）您会收到适合的课程方案建议",
                "based on your child’s needs and goals.": "基于您孩子的需求和目标。",
                "4) Lessons begin with a clear plan": "4）课程以清晰计划开始",
                ", weekly guidance, and ongoing progress tracking.": "，配合每周指导和持续进度跟踪。",
                "Program Setup ($80) applies only if continuing, when an individual term plan is prepared.": "仅在继续学习并制定个人学期计划时，才收取课程设置费（$80）。",
                "How the Fortepiano System Works": "Fortepiano 体系如何运作",
                "Assessment → Term Planning → Progress Tracking → Exam/Recital": "评估 → 学期计划 → 进度跟踪 → 考试/音乐会",
                "Every journey begins with an assessment lesson to evaluate skills and goals. The teacher then recommends the most suitable program pathway.": "每段学习旅程都从评估课开始，用于了解技能和目标。随后教师会推荐最适合的课程路径。",
                "Download the guide and discover how Fortepiano Academy turns lessons into lasting success — built upon years of teaching and student achievement.": "下载指南，了解 Fortepiano Academy 如何基于多年教学经验和学生成就，将课程转化为持久成功。",
                "Some students begin with one lesson per week, while others follow a more supported pathway with stronger accountability and AMEB preparation. All students begin with an Initial Assessment and are placed into the program best suited to their goals.": "有些学生从每周一节课开始，另一些学生则选择支持更充分、责任感更强并包含 AMEB 准备的路径。所有学生都从初次评估开始，并被安排到最适合其目标的方案中。",
                "Tuition is billed monthly in advance. Standard lesson rates are reference only; lessons are offered through structured programs rather than casual bookings.": "学费按月预付。标准课时费仅供参考；课程以系统化方案提供，而不是零散预约。",
                "Foundation": "基础方案",
                "A steady pathway for families who can support regular practice at home.": "适合能在家支持规律练习的家庭的稳定路径。",
                "FORMAT": "形式",
                "1 lesson per week": "每周 1 节课",
                "BEST FOR": "最适合",
                "Casual learners": "轻松学习者",
                "Families with tighter schedules": "时间安排较紧的家庭",
                "Students progressing at a relaxed pace": "以较轻松节奏进步的学生",
                "INCLUDES": "包含",
                "Weekly practice diary": "每周练习日记",
                "Term-based learning plan": "按学期制定的学习计划",
                "Participation in studio recitals": "参加工作室音乐会",
                "Limited support outside lesson hours": "课外有限支持",
                "SUMMARY": "总结",
                "A stable entry point into piano study, ideal for families seeking steadiness. Maximum flexibility, but much greater reliance on consistent home practice.": "进入钢琴学习的稳定起点，适合追求稳步学习的家庭。灵活性最高，但更依赖在家的持续练习。",
                "Development": "发展方案",
                "Recommended": "推荐",
                "The core structured pathway for stronger progress, regular guidance, and AMEB readiness.": "核心系统化路径，帮助学生取得更强进步、获得规律指导并为 AMEB 做好准备。",
                "2 lessons per week": "每周 2 节课",
                "Exam-oriented students": "以考试为目标的学生",
                "Families seeking predictable, measurable progress": "希望进步可预测、可衡量的家庭",
                "Students aiming to complete grades efficiently": "希望高效完成级别的学生",
                "Everything in Foundation, plus:": "包含基础方案全部内容，另加：",
                "Two weekly lessons (with frequency-based value)": "每周两节课（基于频率的价值）",
                "Monthly progress reports": "每月进度报告",
                "Structured AMEB exam preparation": "系统化 AMEB 考试准备",
                "Mock exams and readiness checks": "模拟考试和准备度检查",
                "Teacher-managed AMEB enrolments and exam fees covered by the academy": "由教师管理 AMEB 报名，考试费用由学院承担",
                "Outside-lesson support on demand (text/video support upon discussion and availability)": "按需提供课外支持（文字/视频支持，视沟通和时间安排而定）",
                "The most comprehensive and recommended pathway for serious students and families who value structure, oversight, and consistency.": "最全面且推荐的路径，适合认真学习并重视结构、监督和持续性的学生与家庭。",
                "Start Your Journey": "开始您的学习旅程",
                "Fill in the form and we’ll arrange your first lesson.": "填写表格，我们会安排您的第一节课。",
                "Name": "姓名",
                "Phone / Email": "电话 / 邮箱",
                "Child’s Age / Level": "孩子年龄 / 水平",
                "Message": "留言",
                "Send": "发送",
                "By submitting this form, you agree to our": "提交此表格即表示您同意我们的",
                ".": "。",
                "Frequently Asked Questions": "常见问题",
                "When can students start lessons?": "学生什么时候可以开始上课？",
                "Students can start at any time during the year. Fortepiano Academy operates on rolling enrolment rather than fixed school terms. Each student is placed into the appropriate level and program cycle based on their ability and goals.": "学生全年任何时间都可以开始。Fortepiano Academy 采用滚动招生，而非固定校历学期。每位学生会根据能力和目标被安排到合适的级别和课程周期。",
                "Is the program tied to school terms?": "课程是否与学校学期绑定？",
                "No. Programs are grade-based rather than calendar-based. This allows students to begin when they are ready and progress without being restricted by school term dates.": "不是。课程按级别而非日历安排。这让学生能在准备好时开始，并不受学校学期日期限制地进步。",
                "How do AMEB exams fit into the program?": "AMEB 考试如何融入课程？",
                "AMEB exam preparation is integrated into the curriculum for students following an examination pathway. Preparation begins well in advance, ensuring students are confident and ready regardless of the final exam date allocated by AMEB.": "对于走考试路径的学生，AMEB 备考会融入课程。准备会提前开始，确保无论 AMEB 最终安排的考试日期如何，学生都能自信并准备充分。",
                "Does my child have to do an exam?": "我的孩子必须参加考试吗？",
                "No. AMEB exams are optional. Students may follow an exam pathway or focus on musicianship, technique, repertoire, and performance without sitting formal examinations.": "不需要。AMEB 考试是可选的。学生可以选择考试路径，也可以不参加正式考试，专注于音乐素养、技巧、曲目和表演。",
                "How is lesson length decided?": "课时长度如何决定？",
                "Lesson length is determined after an initial assessment, based on the student’s age, level, learning pace, and goals. As students progress, lesson length may increase to ensure sufficient time for technical work and repertoire.": "课时长度会在初次评估后，根据学生年龄、水平、学习速度和目标确定。随着学生进步，课时可能增加，以确保有足够时间进行技术训练和曲目学习。",
                "What makes Fortepiano Academy different?": "Fortepiano Academy 有什么不同？",
                "Fortepiano Academy offers structured programs with clear progression, disciplined technical training influenced by Russian pedagogy, regular progress tracking, and a supportive learning environment combined with the flexibility of the AMEB syllabus.": "Fortepiano Academy 提供系统化课程、清晰进阶路径、受俄罗斯教学法影响的严谨技术训练、规律进度跟踪，以及支持性的学习环境，并结合 AMEB 大纲的灵活性。",
                "How do I enrol myself or my child in piano lessons?": "我如何为自己或孩子报名钢琴课？",
                "Enrolment begins with a short conversation via call or message to discuss the student’s age, experience, goals, and availability. An initial assessment lesson is then booked.": "报名从一次简短电话或消息沟通开始，用于了解学生年龄、经验、目标和可用时间。随后会预约初次评估课。",
                "At what age can my child start piano lessons?": "孩子几岁可以开始学钢琴？",
                "Children can begin lessons from around 4 years old, depending on their focus, coordination, and readiness. Piano lessons also support the development of concentration, listening skills, and fine motor control.": "孩子大约 4 岁起可以开始，具体取决于专注力、协调能力和准备程度。钢琴课也有助于培养专注力、听觉能力和精细动作控制。",
                "Do you prepare students for performances and exams?": "你们会为表演和考试做准备吗？",
                "Yes. Students are encouraged to participate in studio performances, recitals, and AMEB examinations.": "会。我们鼓励学生参加工作室演出、音乐会和 AMEB 考试。",
                "What if my child has a busy schedule with other activities?": "如果孩子还有其他活动、日程很忙怎么办？",
                "Flexible scheduling is available where possible. For busy students, more frequent lessons are often recommended, as they reduce reliance on long independent practice sessions and help maintain steady progress.": "在可行情况下可灵活安排时间。对于忙碌的学生，通常建议更频繁的课程，因为这能减少对长时间独立练习的依赖，并帮助保持稳定进步。",
                "How often should lessons be scheduled, and how much practice is required?": "课程应该多久一次，需要练习多少？",
                "Twice-weekly lessons are recommended for optimal progress. Practice expectations vary by level:": "为了达到最佳进步，建议每周两节课。练习要求因水平而异：",
                "Beginners: approximately 10–20 minutes per day": "初学者：每天约 10–20 分钟",
                "Intermediate to advanced students: approximately 40–60 minutes per day": "中高级学生：每天约 40–60 分钟",
                "Consistent practice is essential for meaningful progress.": "持续练习是取得实质进步的关键。",
                "What is your cancellation policy?": "你们的取消政策是什么？",
                "Cancellations are requested with at least 24 hours’ notice wherever possible. Each student has one charge-free cancellation per term, usable even with late notice. After this is used, cancellations with 24 hours’ notice are eligible for a make-up lesson or credit (subject to availability). Day-of cancellations and no-shows are forfeited. Make-ups and credits must be used within the same term and cannot be carried over.": "如需取消，请尽可能至少提前 24 小时通知。每位学生每学期有一次免收费取消机会，即使临时通知也可使用。使用后，提前 24 小时取消的课程可获得补课或课时抵扣（视可用时间而定）。当天取消和未到课将视为放弃。补课和抵扣必须在同一学期内使用，不能顺延。",
                "Fortepiano Academy": "Fortepiano Academy",
                "WWCC · Public Liability · Creative Kids Provider": "WWCC · 公共责任保险 · Creative Kids 提供方",
                "Principal Teacher": "首席教师",
                "Meet Liana": "认识 Liana",
                "Russian-trained piano teacher in Wentworth Point": "在 Wentworth Point 任教、受俄罗斯训练的钢琴教师",
                "Read Full Profile": "阅读完整简介",
                "Founder and Principal Piano Teacher of Fortepiano Academy": "Fortepiano Academy 创始人兼首席钢琴教师",
                "Moscow Training": "莫斯科训练",
                "A Russian Music-School Foundation": "俄罗斯音乐学校基础",
                "Music Subjects Completed": "已完成音乐科目",
                "Piano": "钢琴",
                "Piano Performance": "钢琴演奏",
                "Solfeggio": "视唱练耳",
                "Music Literature": "音乐文献",
                "Choir": "合唱",
                "Early Achievement and Performance Background": "早期成就与表演背景",
                "Her award records include:": "她的获奖记录包括：",
                "Teaching Philosophy": "教学理念",
                "Structured, Warm, and Serious About Progress": "系统、温暖，并认真关注进步",
                "What Students Learn": "学生学习内容",
                "Why Families Choose This Approach": "家庭选择这种方法的原因",
                "Ready to begin?": "准备开始了吗？",
                "Blog posts, handwritten, sourced from years of experience": "源自多年经验、亲手撰写的博客文章",
                "Dive deeper into the topics of piano lessons and music.": "深入了解钢琴课程和音乐相关主题。",
                "Latest Articles": "最新文章",
                "What Is the Best Age to Start Piano Lessons for Your Child?": "孩子几岁开始学钢琴最好？",
                "A practical guide for families deciding whether their child is ready for structured piano lessons.": "一份实用指南，帮助家庭判断孩子是否已准备好开始系统化钢琴课程。",
                "Read Article": "阅读文章",
                "Piano lesson advice for families in Wentworth Point and surrounding Sydney suburbs.": "为 Wentworth Point 及悉尼周边社区家庭提供钢琴课程建议。",
                "Thinking about piano lessons for your child?": "正在考虑让孩子学钢琴吗？",
                "An initial assessment can help decide whether your child is ready and what lesson structure will suit them best.": "初次评估可以帮助判断孩子是否准备好，以及哪种课程结构最适合他们。",
                "Privacy Policy for Fortepiano Academy": "Fortepiano Academy 隐私政策",
                "Last updated: 2025": "最后更新：2025",
                "Information We Collect": "我们收集的信息",
                "How We Use Information": "我们如何使用信息",
                "Contact Us": "联系我们"
          },
          "attrs": {
                "Toggle navigation": "切换导航菜单",
                "Toggle theme": "切换主题",
                "Fortepiano Academy home": "Fortepiano Academy 首页",
                "Fortepiano Academy logo dark": "Fortepiano Academy 深色标志",
                "Fortepiano Academy logo light": "Fortepiano Academy 浅色标志",
                "Teacher and student at the piano": "教师和学生在钢琴旁",
                "Piano Lessons Wentworth Point | Fortepiano Academy": "Wentworth Point 钢琴课程 | Fortepiano Academy",
                "Principal Piano Teacher | Liana | Fortepiano Academy": "首席钢琴教师 | Liana | Fortepiano Academy",
                "Piano Lessons Blog | Fortepiano Academy Wentworth Point": "钢琴课程博客 | Fortepiano Academy Wentworth Point",
                "Best Age to Start Piano Lessons for Kids | Fortepiano Academy": "孩子开始学钢琴的最佳年龄 | Fortepiano Academy",
                "Structured one-on-one piano lessons for children and teens in Wentworth Point. Build confidence, technique, musical understanding, and AMEB-ready progress through guided private lessons.": "位于 Wentworth Point 的儿童和青少年系统化一对一钢琴课程。通过有指导的私人课程培养自信、技巧、音乐理解力，并为 AMEB 做好准备。"
          }
    }
  };

  const normalise = (value) => value.replace(/\s+/g, " ").trim();
  const readPreference = () => {
    try {
      return localStorage.getItem(STORAGE_KEY);
    } catch (error) {
      return null;
    }
  };
  const savePreference = (preference) => {
    try {
      localStorage.setItem(STORAGE_KEY, preference);
    } catch (error) {
      // Ignore storage failures so language switching still works for this page view.
    }
  };
  const localeMatches = (locale, language) => new RegExp(`^${language}(?:-|$)`, "i").test(locale || "");
  const systemLanguage = () => {
    const languages = Array.isArray(navigator.languages) && navigator.languages.length
      ? navigator.languages
      : [navigator.language || navigator.userLanguage || "en"];
    if (languages.some((locale) => localeMatches(locale, "zh"))) return "zh";
    if (languages.some((locale) => localeMatches(locale, "vi"))) return "vi";
    return "en";
  };
  const savedPreference = () => {
    const saved = readPreference();
    return SUPPORTED.has(saved) ? saved : "auto";
  };
  const activeLanguage = (preference = savedPreference()) =>
    preference === "auto" ? systemLanguage() : preference;

  const translateTextNode = (node, dictionary) => {
    const source = node.i18nSource || node.nodeValue;
    node.i18nSource = source;
    const key = normalise(source);
    if (!key) return;
    const replacement = dictionary && dictionary[key];
    if (!replacement) {
      node.nodeValue = source;
      return;
    }
    const leading = source.match(/^\s*/)[0];
    const trailing = source.match(/\s*$/)[0];
    node.nodeValue = `${leading}${replacement}${trailing}`;
  };

  const translateAttributes = (language) => {
    const dictionary = translations[language]?.attrs || {};
    const attrs = ["aria-label", "alt", "title", "placeholder", "content", "value"];
    document.querySelectorAll("[aria-label], [alt], [title], [placeholder], meta[content], input[value], button[value]")
      .forEach((element) => {
        attrs.forEach((attr) => {
          if (!element.hasAttribute(attr)) return;
          const sourceAttr = `data-i18n-original-${attr}`;
          if (!element.hasAttribute(sourceAttr)) element.setAttribute(sourceAttr, element.getAttribute(attr));
          const source = element.getAttribute(sourceAttr);
          const replacement = dictionary[normalise(source)];
          element.setAttribute(attr, replacement || source);
        });
      });

    const originalTitle = document.documentElement.dataset.i18nOriginalTitle || document.title;
    document.documentElement.dataset.i18nOriginalTitle = originalTitle;
    document.title = dictionary[normalise(originalTitle)] || originalTitle;
  };

  const updateLanguageControlLabels = (language) => {
    const label = document.querySelector(".language-select__label");
    const auto = document.querySelector('#languageSelect option[value="auto"]');
    const english = document.querySelector('#languageSelect option[value="en"]');
    const vietnamese = document.querySelector('#languageSelect option[value="vi"]');
    const chinese = document.querySelector('#languageSelect option[value="zh"]');
    const select = document.getElementById("languageSelect");

    const labels = {
      en: { label: "Language", auto: "Auto", english: "English", vietnamese: "Tiếng Việt", chinese: "中文", aria: "Choose language" },
      vi: { label: "Ngôn ngữ", auto: "Tự động", english: "Tiếng Anh", vietnamese: "Tiếng Việt", chinese: "Tiếng Trung", aria: "Chọn ngôn ngữ" },
      zh: { label: "语言", auto: "自动", english: "英语", vietnamese: "越南语", chinese: "中文", aria: "选择语言" },
    }[language] || { label: "Language", auto: "Auto", english: "English", vietnamese: "Tiếng Việt", chinese: "中文", aria: "Choose language" };

    if (label) label.textContent = labels.label;
    if (auto) auto.textContent = labels.auto;
    if (english) english.textContent = labels.english;
    if (vietnamese) vietnamese.textContent = labels.vietnamese;
    if (chinese) chinese.textContent = labels.chinese;
    if (select) select.setAttribute("aria-label", labels.aria);
  };

  const applyLanguage = (preference = savedPreference()) => {
    const language = activeLanguage(preference);
    const dictionary = translations[language]?.strings || null;

    const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, {
      acceptNode: (node) => {
        const parent = node.parentElement;
        if (!parent || ["SCRIPT", "STYLE", "NOSCRIPT", "TEXTAREA", "OPTION"].includes(parent.tagName)) {
          return NodeFilter.FILTER_REJECT;
        }
        if (parent.closest(".language-select")) return NodeFilter.FILTER_REJECT;
        return normalise(node.nodeValue) ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_REJECT;
      }
    });

    const nodes = [];
    while (walker.nextNode()) nodes.push(walker.currentNode);
    nodes.forEach((node) => translateTextNode(node, dictionary));
    translateAttributes(language);
    updateLanguageControlLabels(language);

    document.documentElement.lang = language === "zh" ? "zh-Hans" : language === "vi" ? "vi" : "en";
    document.documentElement.dataset.language = language;
    document.documentElement.dataset.languagePreference = preference;

    const select = document.getElementById("languageSelect");
    if (select) select.value = preference;
  };

  const languageOptions = [
    ["auto", "Auto"],
    ["en", "English"],
    ["vi", "Tiếng Việt"],
    ["zh", "中文"],
  ];

  const ensureLanguageOptions = (select) => {
    languageOptions.forEach(([value, label]) => {
      if (select.querySelector(`option[value="${value}"]`)) return;
      const option = document.createElement("option");
      option.value = value;
      option.textContent = label;
      select.appendChild(option);
    });
  };

  const bindLanguageSelect = (select) => {
    if (!select || select.dataset.languageBound === "true") return;
    select.dataset.languageBound = "true";
    select.value = savedPreference();
    select.addEventListener("change", () => {
      const preference = SUPPORTED.has(select.value) ? select.value : "auto";
      savePreference(preference);
      applyLanguage(preference);
    });
  };

  const addLanguageControl = () => {
    const menu = document.getElementById("navMenu");
    if (!menu) return;

    let select = document.getElementById("languageSelect");
    if (!select) {
      const item = document.createElement("li");
      item.className = "nav__language";
      item.innerHTML = `
        <label class="language-select" for="languageSelect">
          <span class="language-select__label">Language</span>
          <select id="languageSelect" class="language-select__control" aria-label="Choose language"></select>
        </label>`;

      const themeItem = menu.querySelector(".nav__theme");
      menu.insertBefore(item, themeItem || null);
      select = item.querySelector("select");
    }

    ensureLanguageOptions(select);
    bindLanguageSelect(select);
  };

  const init = () => {
    addLanguageControl();
    applyLanguage(savedPreference());
  };

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init, { once: true });
  } else {
    init();
  }

  window.addEventListener("languagechange", () => {
    if (savedPreference() === "auto") applyLanguage("auto");
  });
})();
