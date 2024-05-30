import sys
from PyPDF2 import PdfFileReader
from io import BytesIO
from reportlab.lib.pagesizes import letter
from reportlab.pdfgen import canvas
from transformers import pipeline

def extract_text_from_pdf(pdf_path):
    with open(pdf_path, 'rb') as f:
        reader = PdfFileReader(f)
        text = ''
        for page_num in range(reader.numPages):
            text += reader.getPage(page_num).extract_text()
    return text

def summarize_text(text):
    summarizer = pipeline("summarization")
    summary = summarizer(text, max_length=200, min_length=30, do_sample=False)
    return summary[0]['summary_text']

def generate_summary_pdf(summary, output_path):
    c = canvas.Canvas(output_path, pagesize=letter)
    width, height = letter
    c.setFont("Helvetica", 12)

    text_object = c.beginText(40, height - 40)
    for line in summary.split('\n'):
        text_object.textLine(line)

    c.drawText(text_object)
    c.showPage()
    c.save()

def main(pdf_path, output_path):
    try:
        text = extract_text_from_pdf(pdf_path)
        if not text.strip():
            raise ValueError("No text extracted from the PDF")

        summary = summarize_text(text)
        if not summary.strip():
            raise ValueError("No summary generated")

        generate_summary_pdf(summary, output_path)
    except Exception as e:
        with open("error_log.txt", "w") as error_file:
            error_file.write(str(e))
        raise

if __name__ == "__main__":
    pdf_path = sys.argv[1]
    output_path = sys.argv[2]
    main(pdf_path, output_path)
