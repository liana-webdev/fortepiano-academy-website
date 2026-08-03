"""Generate the responsive image derivatives used by the PHP templates.

Run from the repository root. Originals remain the source of truth; generated
AVIF and WebP files are written to images/responsive without upscaling.
"""

from pathlib import Path

from PIL import Image, ImageOps


ROOT = Path(__file__).resolve().parents[1]
OUTPUT = ROOT / "images" / "responsive"

IMAGE_SETS = {
    "hero-lesson": (ROOT / "img" / "Aveena February 2022.jpg", (480, 768, 1200, 1600)),
    "practice-diaries": (ROOT / "img" / "students sitting at studio holding diaries old.JPG", (480, 768, 1200, 1600)),
    "recital-group": (ROOT / "img" / "recital group photo with certificates.JPG", (480, 768, 1200)),
    "faculty-recital": (ROOT / "img" / "recital teacher and jennie.JPG", (480, 768)),
    "beginner-lesson": (ROOT / "images" / "beginner-piano-lesson.jpg", (480, 768, 1200, 1600)),
    "studio-lesson": (ROOT / "images" / "piano-lesson-wentworth-point.jpg", (480, 768, 1200, 1600)),
    "student-angus": (ROOT / "img" / "Angus.png", (480, 768, 1200)),
    "student-jonas": (ROOT / "img" / "Jonas.png", (480, 768, 1200)),
    "student-jarick": (ROOT / "img" / "Jarick.png", (480, 768)),
    "student-jennifer-jacob": (ROOT / "img" / "Jennifer and Jacob.png", (480, 768, 1200)),
    "student-jennie": (ROOT / "img" / "Jennie.png", (480, 768, 1200)),
    "student-amin": (ROOT / "img" / "Amin.png", (480, 768, 1200)),
    "recital-jennie": (ROOT / "img" / "recital teacher and jennie.JPG", (480, 768)),
    "recital-amin": (ROOT / "img" / "recital teacher and amin.JPG", (480, 768)),
    "recital-certificates": (ROOT / "img" / "kids holding cert.JPG", (480, 768, 1200)),
    "recital-parents": (ROOT / "img" / "recital group photo with parents.JPG", (480, 768, 1200)),
}


def generate() -> None:
    OUTPUT.mkdir(parents=True, exist_ok=True)

    for slug, (source, widths) in IMAGE_SETS.items():
        with Image.open(source) as opened:
            image = ImageOps.exif_transpose(opened).convert("RGB")
            source_width, source_height = image.size

            for width in widths:
                if width > source_width:
                    continue
                height = round(source_height * width / source_width)
                resized = image.resize((width, height), Image.Resampling.LANCZOS)
                resized.save(OUTPUT / f"{slug}-{width}.avif", "AVIF", quality=52, speed=6)
                resized.save(OUTPUT / f"{slug}-{width}.webp", "WEBP", quality=78, method=6)
                print(f"{slug}-{width}: {width}x{height}")


if __name__ == "__main__":
    generate()
