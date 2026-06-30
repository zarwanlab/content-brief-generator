# AI Content Brief Generator

A professional, minimal, and modern single-page application built with Laravel and powered by AI to generate comprehensive content briefs based on keywords.

## 🚀 Features

- **AI-Powered Analysis**: Generates full article plans using advanced AI models (gpt-oss-120b).
- **SEO Optimization**: Provides suggested H1 titles, Meta Descriptions, and full article structures (H2/H3).
- **Keyword Research**: Includes LSI keywords and suggested FAQs for better ranking.
- **International Support**: Supports multiple languages and target countries (Persian, English, Arabic, etc.).
- **Modern UI**: Clean, responsive, and pixel-perfect design with glassmorphism effects and smooth animations.
- **Export Options**: Export your briefs as PDF, copy to clipboard, or print directly.

## 📋 Prerequisites

- **PHP**: >= 8.2
- **Composer**: Latest version
- **Web Server**: Apache, Nginx, or use built-in PHP server (Artisan)
- **Database**: Not required. The application works entirely without a database by using the `file` driver for sessions and cache.

## 🛠️ Installation

Follow these steps to set up the project locally:

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd content-brief-generator
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Environment Setup**:
   Copy the example environment file and configure your settings:
   ```bash
   cp .env.example .env
   ```

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Run the Application**:
   Start the local development server:
   ```bash
   php artisan serve
   ```
   The application will be available at `http://127.0.0.1:8000`.

## 🤖 Custom AI Integration

You can easily switch the AI model or use your own custom AI provider. The system uses a standard OpenAI-compatible API structure. To configure your own AI:

1. Open your `.env` file.
2. Update the following variables:
   - `AI_BASE_URL`: The base URL of your AI provider (e.g., `https://api.openai.com/v1`).
   - `AI_API_TOKEN`: Your secret API key.
   - `AI_MODEL`: The model name you wish to use (e.g., `gpt-4`).

The application expects the AI to respond in a structured JSON format as defined in the system prompt.

## 📖 Usage

1. Enter your **Main Keyword**.
2. Select the **Target Language/Country**.
3. (Optional) Provide additional **Description** or **Competitor URLs**.
4. Click **"Generate Brief"** and wait for the AI to process.
5. Review your brief and use the **Copy** or **Download PDF** buttons to export.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
