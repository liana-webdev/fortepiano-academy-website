// scripts/script.js

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

// Language preference and Vietnamese localisation
(() => {
  const STORAGE_KEY = "languagePreference"; // stores: "auto", "en", or "vi"
  const SUPPORTED = new Set(["auto", "en", "vi"]);

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
  const isVietnamese = (locale) => /^vi(?:-|$)/i.test(locale || "");
  const systemLanguage = () => {
    const languages = Array.isArray(navigator.languages) && navigator.languages.length
      ? navigator.languages
      : [navigator.language || navigator.userLanguage || "en"];
    return languages.some(isVietnamese) ? "vi" : "en";
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
    const select = document.getElementById("languageSelect");

    if (label) label.textContent = language === "vi" ? "Ngôn ngữ" : "Language";
    if (auto) auto.textContent = language === "vi" ? "Tự động" : "Auto";
    if (english) english.textContent = language === "vi" ? "Tiếng Anh" : "English";
    if (select) select.setAttribute("aria-label", language === "vi" ? "Chọn ngôn ngữ" : "Choose language");
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

    document.documentElement.lang = language === "vi" ? "vi" : "en";
    document.documentElement.dataset.language = language;
    document.documentElement.dataset.languagePreference = preference;

    const select = document.getElementById("languageSelect");
    if (select) select.value = preference;
  };

  const addLanguageControl = () => {
    const menu = document.getElementById("navMenu");
    if (!menu || document.getElementById("languageSelect")) return;

    const item = document.createElement("li");
    item.className = "nav__language";
    item.innerHTML = `
      <label class="language-select" for="languageSelect">
        <span class="language-select__label">Language</span>
        <select id="languageSelect" class="language-select__control" aria-label="Choose language">
          <option value="auto">Auto</option>
          <option value="en">English</option>
          <option value="vi">Tiếng Việt</option>
        </select>
      </label>`;

    const themeItem = menu.querySelector(".nav__theme");
    menu.insertBefore(item, themeItem || null);

    const select = item.querySelector("select");
    select.value = savedPreference();
    select.addEventListener("change", () => {
      const preference = SUPPORTED.has(select.value) ? select.value : "auto";
      savePreference(preference);
      applyLanguage(preference);
    });
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
