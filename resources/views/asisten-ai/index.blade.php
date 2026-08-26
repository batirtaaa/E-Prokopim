@extends('layouts.app')
@section('title', 'Asisten AI Prokopim — E-PROKOPIM')

@push('styles')
<style>
.ai-chat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    display: flex;
    flex-direction: column;
    height: calc(100vh - 110px);
    min-height: 600px;
    overflow: hidden;
    margin: 0 auto;
    position: relative;
}

/* Header */
.ai-chat-header {
    padding: 14px 24px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #ffffff;
}
.ai-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.ai-bot-avatar-header {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #0f2942;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.ai-header-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 2px 0;
    letter-spacing: -0.01em;
    display: flex;
    align-items: center;
    gap: 8px;
}
.ai-header-subtitle {
    font-size: 12.5px;
    color: #64748b;
    margin: 0;
}

.ai-header-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}
.ai-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 9999px;
    font-size: 11.5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
}
.ai-status-badge.active {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    color: #1d4ed8;
}
.ai-status-badge.fallback {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    color: #475569;
}
.ai-pulse-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #22c55e;
}
.ai-pulse-dot.fallback {
    background: #64748b;
}

.ai-btn-header {
    background: none;
    border: 1px solid #e2e8f0;
    color: #64748b;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s;
    text-decoration: none;
}
.ai-btn-header:hover {
    border-color: #cbd5e1;
    color: #0f172a;
    background: #f8fafc;
}
.ai-btn-header.danger:hover {
    border-color: #fca5a5;
    color: #dc2626;
    background: #fef2f2;
}

/* Chat Messages Stream */
.ai-messages-area {
    flex: 1;
    overflow-y: auto;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    background: #ffffff;
    scroll-behavior: smooth;
}

/* Bot Message Block */
.ai-msg-bot {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    max-width: 82%;
}
.ai-msg-sender-bot {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: #64748b;
    margin-bottom: 6px;
    font-weight: 500;
}
.ai-msg-sender-bot .bot-icon-small {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: #0f2942;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
}
.ai-msg-bubble-bot {
    background: #f0f7ff;
    border: 1px solid #e0eeff;
    border-radius: 4px 16px 16px 16px;
    padding: 13px 18px;
    font-size: 13.5px;
    color: #1e293b;
    line-height: 1.5;
}
.ai-msg-bubble-bot p {
    margin: 0 0 7px 0;
    line-height: 1.5;
}
.ai-msg-bubble-bot p:last-child {
    margin-bottom: 0;
}
.ai-msg-bubble-bot br + br {
    display: none;
}

/* User Message Block */
.ai-msg-user {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    max-width: 78%;
    align-self: flex-end;
}
.ai-msg-sender-user {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: #64748b;
    margin-bottom: 6px;
    font-weight: 500;
}
.ai-msg-sender-user .user-avatar-small {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #334155;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 700;
}
.ai-msg-bubble-user {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    border-radius: 16px 4px 16px 16px;
    padding: 12px 18px;
    font-size: 13.5px;
    color: #0f172a;
    line-height: 1.5;
}

/* File Badges in User Messages */
.ai-file-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 8px 12px;
    margin-bottom: 8px;
    text-decoration: none;
    color: #0f172a;
    font-size: 12.5px;
    font-weight: 500;
    transition: all 0.15s ease;
}
.ai-file-badge:hover {
    border-color: #3b82f6;
    background: #f8fafc;
}
.ai-img-preview-msg {
    max-width: 260px;
    max-height: 200px;
    border-radius: 8px;
    margin-bottom: 8px;
    display: block;
    object-fit: cover;
    border: 1px solid #cbd5e1;
}

/* Structured Schedule Card Inside Message */
.ai-schedule-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px 16px;
    margin: 12px 0 8px 0;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
}
.ai-schedule-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 8px 0;
    border-bottom: 1px solid #f1f5f9;
}
.ai-schedule-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.ai-schedule-item:first-child {
    padding-top: 0;
}
.ai-schedule-time {
    font-weight: 700;
    color: #0f172a;
    font-size: 13px;
    min-width: 52px;
}
.ai-schedule-details {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.ai-schedule-title {
    font-weight: 600;
    color: #0f172a;
    font-size: 13px;
}
.ai-schedule-location {
    font-size: 12px;
    color: #64748b;
}

/* Mail Summary Card */
.ai-mail-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px 16px;
    margin: 12px 0 8px 0;
}
.ai-mail-item {
    padding: 8px 0;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.ai-mail-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.ai-mail-item:first-child {
    padding-top: 0;
}

/* Typing Indicator Animation */
.ai-typing-indicator {
    display: none;
    align-items: center;
    gap: 4px;
    padding: 8px 14px;
    background: #f0f7ff;
    border-radius: 12px;
    width: fit-content;
    margin-top: 4px;
}
.ai-typing-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #3b82f6;
    animation: aiDotBounce 1.4s infinite ease-in-out both;
}
.ai-typing-dot:nth-child(1) { animation-delay: -0.32s; }
.ai-typing-dot:nth-child(2) { animation-delay: -0.16s; }
@keyframes aiDotBounce {
    0%, 80%, 100% { transform: scale(0); opacity: 0.4; }
    40% { transform: scale(1); opacity: 1; }
}

/* Bottom Controls Section */
.ai-chat-bottom {
    padding: 12px 24px 18px 24px;
    border-top: 1px solid #f1f5f9;
    background: #ffffff;
}

/* Quick Prompt Pills */
.ai-chips-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
    flex-wrap: wrap;
}
.ai-chip-btn {
    padding: 6px 14px;
    border-radius: 9999px;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    font-size: 12.5px;
    font-weight: 500;
    color: #475569;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease;
    user-select: none;
}
.ai-chip-btn:hover {
    background: #e2e8f0;
    color: #0f172a;
    border-color: #cbd5e1;
}

/* Attachment Preview Bar */
.ai-attached-preview {
    display: none;
    align-items: center;
    gap: 10px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    padding: 6px 12px;
    border-radius: 8px;
    margin-bottom: 10px;
    width: fit-content;
    font-size: 12.5px;
    color: #166534;
}
.ai-attached-preview.show {
    display: flex;
}
.ai-attached-cancel {
    background: none;
    border: none;
    color: #991b1b;
    cursor: pointer;
    font-size: 14px;
    font-weight: 700;
    padding: 0 4px;
}

/* Input Bar */
.ai-input-bar {
    display: flex;
    align-items: center;
    border: 1.5px solid #cbd5e1;
    border-radius: 12px;
    padding: 6px 8px 6px 14px;
    background: #ffffff;
    transition: all 0.15s ease;
}
.ai-input-bar:focus-within {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.ai-clip-icon {
    color: #64748b;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s ease;
    padding: 4px;
    border-radius: 6px;
}
.ai-clip-icon:hover {
    color: #0f172a;
    background: #f1f5f9;
}
.ai-text-input {
    flex: 1;
    border: none;
    outline: none;
    font-size: 13.5px;
    color: #1e293b;
    font-family: inherit;
    background: transparent;
    padding: 4px 8px;
}
.ai-text-input::placeholder {
    color: #94a3b8;
}
.ai-send-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: #0f2942;
    border: none;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.15s ease;
    flex-shrink: 0;
}
.ai-send-btn:hover {
    background: #081d30;
}

/* Footer Disclaimer */
.ai-disclaimer {
    text-align: center;
    font-size: 11px;
    color: #94a3b8;
    margin-top: 8px;
    margin-bottom: 0;
}

/* Modal Popup Settings */
.ai-modal-overlay {
    display: none;
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, 0.45);
    backdrop-filter: blur(2px);
    z-index: 100;
    align-items: center;
    justify-content: center;
}
.ai-modal-overlay.show {
    display: flex;
}
.ai-modal-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    width: 90%;
    max-width: 480px;
    padding: 24px;
    box-sizing: border-box;
}
.ai-modal-title {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 6px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.ai-modal-desc {
    font-size: 12.5px;
    color: #64748b;
    line-height: 1.5;
    margin: 0 0 16px 0;
}
.ai-modal-input {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 13px;
    color: #1e293b;
    box-sizing: border-box;
    outline: none;
    font-family: monospace;
    margin-bottom: 8px;
}
.ai-modal-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.ai-modal-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
    margin-top: 16px;
}
</style>
@endpush

@section('content')
<div class="ai-chat-card">

    {{-- Flash Message --}}
    @if(session('success'))
    <div style="background:#f0fdf4; border-bottom:1px solid #bbf7d0; color:#166534; padding:8px 24px; font-size:12.5px; display:flex; align-items:center; justify-content:space-between;">
        <span>✓ {{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" style="background:none; border:none; color:#166534; cursor:pointer;">&times;</button>
    </div>
    @endif

    {{-- Chat Header --}}
    <div class="ai-chat-header">
        <div class="ai-header-left">
            <div class="ai-bot-avatar-header">
                {{-- Robot / Bot icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                    <path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.38-1 1.72V7h4a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3v-8a3 3 0 0 1 3-3h4V5.72A2.001 2.001 0 0 1 12 2zm-3 8a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm6 0a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-6.5 6a.75.75 0 0 0 0 1.5h7a.75.75 0 0 0 0-1.5h-7z"/>
                </svg>
            </div>
            <div>
                <h2 class="ai-header-title">
                    <span>Asisten AI Prokopim</span>
                    @if($currentApiKey)
                        <span class="ai-status-badge active" onclick="openApiKeyModal()" title="Terhubung ke Google Gemini AI (Klik untuk ubah)">
                            <span class="ai-pulse-dot"></span> Gemini AI Aktif
                        </span>
                    @else
                        <span class="ai-status-badge fallback" onclick="openApiKeyModal()" title="Terhubung ke Basis Data Prokopim (Klik untuk pasang Gemini API)">
                            <span class="ai-pulse-dot fallback"></span> Engine Database Aktif
                        </span>
                    @endif
                </h2>
                <p class="ai-header-subtitle">Siap membantu tugas administratif Anda dan terhubung ke database E-Prokopim</p>
            </div>
        </div>

        <div class="ai-header-actions">
            <button type="button" class="ai-btn-header" onclick="openApiKeyModal()" title="Pengaturan API Key">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="14" height="14">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                </svg>
                <span>Google Gemini API</span>
            </button>

            <form method="POST" action="{{ route('asisten-ai.clear') }}" onsubmit="return confirm('Bersihkan riwayat percakapan?')" style="margin:0;">
                @csrf
                <button type="submit" class="ai-btn-header danger" title="Bersihkan riwayat">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="14" height="14">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <span>Reset Chat</span>
                </button>
            </form>
        </div>
    </div>

    {{-- Messages Area --}}
    <div class="ai-messages-area" id="aiMessagesArea">
        @foreach($messages as $msg)
            @if($msg->role === 'assistant')
                <div class="ai-msg-bot">
                    <div class="ai-msg-sender-bot">
                        <div class="bot-icon-small">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="12" height="12">
                                <path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.38-1 1.72V7h4a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3v-8a3 3 0 0 1 3-3h4V5.72A2.001 2.001 0 0 1 12 2zm-3 8a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm6 0a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-6.5 6a.75.75 0 0 0 0 1.5h7a.75.75 0 0 0 0-1.5h-7z"/>
                            </svg>
                        </div>
                        <span>Asisten AI • {{ $msg->created_at->format('H:i') }}</span>
                    </div>

                    <div class="ai-msg-bubble-bot">
                        {!! $msg->formatted_content !!}

                        {{-- If structured schedule data exists --}}
                        @if($msg->structured_data && isset($msg->structured_data['type']) && $msg->structured_data['type'] === 'schedule')
                            <div class="ai-schedule-card">
                                @foreach($msg->structured_data['items'] as $sch)
                                    <div class="ai-schedule-item">
                                        <div class="ai-schedule-time">{{ $sch['time'] }}</div>
                                        <div class="ai-schedule-details">
                                            <span class="ai-schedule-title">{{ $sch['title'] }}</span>
                                            <span class="ai-schedule-location">{{ $sch['location'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @elseif($msg->structured_data && isset($msg->structured_data['type']) && $msg->structured_data['type'] === 'mail_summary')
                            <div class="ai-mail-card">
                                @foreach($msg->structured_data['items'] as $mail)
                                    <div class="ai-mail-item">
                                        <span style="font-weight:600; color:#0f172a; font-size:12.5px;">{{ $mail['perihal'] }}</span>
                                        <span style="font-size:11.5px; color:#64748b;">No: {{ $mail['nomor'] }} • Pengirim: {{ $mail['pengirim'] }} ({{ $mail['tanggal'] }})</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="ai-msg-user">
                    <div class="ai-msg-sender-user">
                        <span>Anda • {{ $msg->created_at->format('H:i') }}</span>
                        <div class="user-avatar-small">
                            @if(Auth::user() && Auth::user()->photo)
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" style="width:100%;height:100%;border-radius:50%;object-fit:cover;" alt="">
                            @else
                                {{ substr(Auth::user()->name ?? 'User', 0, 2) }}
                            @endif
                        </div>
                    </div>

                    <div class="ai-msg-bubble-user">
                        {{-- Attached file preview if exists --}}
                        @if($msg->file_path)
                            @if($msg->is_image)
                                <a href="{{ asset('storage/' . $msg->file_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $msg->file_path) }}" class="ai-img-preview-msg" alt="{{ $msg->file_name }}">
                                </a>
                            @elseif($msg->is_video)
                                <video src="{{ asset('storage/' . $msg->file_path) }}" controls style="max-width:280px; border-radius:8px; margin-bottom:8px; display:block;"></video>
                            @else
                                <a href="{{ asset('storage/' . $msg->file_path) }}" target="_blank" class="ai-file-badge">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                    <span>{{ $msg->file_name }} ({{ $msg->formatted_file_size }})</span>
                                </a>
                            @endif
                        @endif

                        {{ $msg->content }}
                    </div>
                </div>
            @endif
        @endforeach

        {{-- Dynamic Typing Indicator --}}
        <div class="ai-typing-indicator" id="aiTypingIndicator">
            <div class="ai-typing-dot"></div>
            <div class="ai-typing-dot"></div>
            <div class="ai-typing-dot"></div>
            <span style="font-size:11.5px; color:#3b82f6; margin-left:6px; font-weight:500;">Asisten AI sedang menganalisis...</span>
        </div>
    </div>

    {{-- Bottom Section --}}
    <div class="ai-chat-bottom">
        {{-- Quick Prompt Chips --}}
        <div class="ai-chips-bar">
            <button type="button" class="ai-chip-btn" onclick="sendQuickPrompt('Ringkas surat masuk hari ini')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                <span>Ringkas surat hari ini</span>
            </button>

            <button type="button" class="ai-chip-btn" onclick="sendQuickPrompt('Buat draf naskah sambutan resmi')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                <span>Buat draf sambutan</span>
            </button>

            <button type="button" class="ai-chip-btn" onclick="sendQuickPrompt('Cek agenda besok')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                <span>Cek agenda besok</span>
            </button>
        </div>

        {{-- Selected Attachment Preview Chip --}}
        <div id="aiAttachedPreview" class="ai-attached-preview">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.373L8.552 18.32a1.5 1.5 0 01-2.122-2.122l9.88-9.878"/></svg>
            <span id="aiAttachedFileName" style="font-weight:600;">Berkas terpilih</span>
            <span id="aiAttachedFileSize" style="color:#15803d; font-size:11.5px;"></span>
            <button type="button" class="ai-attached-cancel" onclick="clearAttachedFile()" title="Batalkan berkas">&times;</button>
        </div>

        {{-- Hidden File Input --}}
        <input type="file" id="aiFileInput" style="display:none;" onchange="handleFileSelected(this)" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.webp,.gif,.mp4,.mov,.txt">

        {{-- Input Form Bar --}}
        <form id="aiChatForm" onsubmit="handleChatSubmit(event)">
            @csrf
            <div class="ai-input-bar">
                <div class="ai-clip-icon" onclick="document.getElementById('aiFileInput').click()" title="Lampirkan berkas, foto, video, atau dokumen">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="19" height="19">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.373L8.552 18.32a1.5 1.5 0 01-2.122-2.122l9.88-9.878" />
                    </svg>
                </div>

                <input type="text" id="aiInputText" class="ai-text-input" placeholder="Tanya asisten AI atau lampirkan dokumen..." autocomplete="off">

                <button type="submit" class="ai-send-btn" id="aiSendBtn" title="Kirim Pesan">
                    {{-- Send Paper Plane Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16">
                        <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                    </svg>
                </button>
            </div>
        </form>

        <p class="ai-disclaimer">Asisten AI Prokopim terhubung secara dinamis dengan Basis Data E-Prokopim &amp; Google Gemini AI.</p>
    </div>

    {{-- API Key Setting Modal --}}
    <div id="aiApiKeyModal" class="ai-modal-overlay" onclick="if(event.target === this) closeApiKeyModal()">
        <div class="ai-modal-card">
            <h3 class="ai-modal-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="18" height="18" style="color:#2563eb;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                </svg>
                <span>Pengaturan Permanen Google Gemini AI</span>
            </h3>
            <p class="ai-modal-desc">
                Hubungkan sistem dengan Google Gemini AI untuk mengaktifkan penalaran cerdas, analisis berkas/foto/PDF, dan integrasi data Prokopim secara otomatis.
            </p>

            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:10px 12px; margin-bottom:14px; font-size:12px; color:#334155;">
                <div style="display:flex; align-items:center; gap:6px; font-weight:600; color:#0f766e; margin-bottom:3px;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="15" height="15">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    <span>Penyimpanan Permanen (.env)</span>
                </div>
                Kunci API yang disimpan di sini akan langsung ditulis ke konfigurasi sistem (<code>.env</code>) sehingga <strong>tidak akan ter-reset</strong> saat laptop dimatikan, ditutup, atau di-restart.
            </div>

            <form method="POST" action="{{ route('asisten-ai.api-key') }}">
                @csrf
                <div style="margin-bottom:12px;">
                    <label style="font-size:12px; font-weight:600; color:#334155; margin-bottom:4px; display:block;">Gemini API Key</label>
                    <div style="position:relative;">
                        <input type="password" name="gemini_api_key" id="geminiApiKeyInput" class="ai-modal-input" style="padding-right:40px;" placeholder="Masukkan Google Gemini API Key (e.g. AIzaSy...)" value="{{ $currentApiKey }}">
                        <button type="button" onclick="toggleApiKeyVisibility()" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; color:#64748b; cursor:pointer; font-size:12px;">
                            👁️
                        </button>
                    </div>
                </div>

                <div style="margin-bottom:12px;">
                    <label style="font-size:12px; font-weight:600; color:#334155; margin-bottom:4px; display:block;">Model Gemini</label>
                    <select name="gemini_model" class="ai-modal-input" style="background:#fff;">
                        <option value="gemini-1.5-flash" {{ ($currentModel ?? '') == 'gemini-1.5-flash' ? 'selected' : '' }}>Gemini 1.5 Flash (Sangat Cepat &amp; Rekomendasi)</option>
                        <option value="gemini-2.0-flash" {{ ($currentModel ?? '') == 'gemini-2.0-flash' ? 'selected' : '' }}>Gemini 2.0 Flash (Generasi Terbaru)</option>
                        <option value="gemini-1.5-pro" {{ ($currentModel ?? '') == 'gemini-1.5-pro' ? 'selected' : '' }}>Gemini 1.5 Pro (Penalaran Kompleks)</option>
                        <option value="gemini-3.1-flash-lite-preview" {{ ($currentModel ?? '') == 'gemini-3.1-flash-lite-preview' ? 'selected' : '' }}>Gemini 3.1 Flash Lite (Preview)</option>
                    </select>
                </div>

                <div style="font-size:11.5px; color:#64748b; margin-top:4px; line-height:1.4;">
                    Dapatkan API Key gratis di <a href="https://aistudio.google.com/app/apikey" target="_blank" style="color:#2563eb; font-weight:600; text-decoration:none;">Google AI Studio ↗</a>.
                </div>

                <div class="ai-modal-actions">
                    <button type="button" class="ai-btn-header" onclick="closeApiKeyModal()">Batal</button>
                    <button type="submit" style="padding:7px 18px; font-size:12.5px; font-weight:600; background:#0f2942; color:#fff; border:none; border-radius:6px; cursor:pointer;">Simpan Permanen</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const messagesArea = document.getElementById('aiMessagesArea');
const typingIndicator = document.getElementById('aiTypingIndicator');
const inputField = document.getElementById('aiInputText');
const sendBtn = document.getElementById('aiSendBtn');
const fileInput = document.getElementById('aiFileInput');
const attachedPreview = document.getElementById('aiAttachedPreview');
const attachedFileName = document.getElementById('aiAttachedFileName');
const attachedFileSize = document.getElementById('aiAttachedFileSize');
const apiKeyModal = document.getElementById('aiApiKeyModal');

let selectedFile = null;

function openApiKeyModal() {
    apiKeyModal.classList.add('show');
}
function closeApiKeyModal() {
    apiKeyModal.classList.remove('show');
}
function toggleApiKeyVisibility() {
    const input = document.getElementById('geminiApiKeyInput');
    if (input) {
        input.type = input.type === 'password' ? 'text' : 'password';
    }
}

// Auto scroll to bottom
function scrollToBottom() {
    messagesArea.scrollTop = messagesArea.scrollHeight;
}
scrollToBottom();

function handleFileSelected(input) {
    if (input.files && input.files[0]) {
        selectedFile = input.files[0];
        attachedFileName.textContent = selectedFile.name;
        
        let sizeStr = '';
        if (selectedFile.size < 1048576) {
            sizeStr = '(' + (selectedFile.size / 1024).toFixed(1) + ' KB)';
        } else {
            sizeStr = '(' + (selectedFile.size / 1048576).toFixed(2) + ' MB)';
        }
        attachedFileSize.textContent = sizeStr;
        attachedPreview.classList.add('show');
        inputField.focus();
    }
}

function clearAttachedFile() {
    selectedFile = null;
    fileInput.value = '';
    attachedPreview.classList.remove('show');
}

function sendQuickPrompt(text) {
    inputField.value = text;
    handleChatSubmit(new Event('submit'));
}

async function handleChatSubmit(e) {
    e.preventDefault();
    const prompt = inputField.value.trim();
    if (!prompt && !selectedFile) return;

    const userPrompt = prompt || (selectedFile ? 'Tolong telaah berkas terlampir ini.' : '');
    const currentFile = selectedFile;

    inputField.value = '';
    clearAttachedFile();
    inputField.disabled = true;
    sendBtn.disabled = true;

    const userTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const userInitials = '{{ substr(Auth::user()->name ?? "User", 0, 2) }}';
    
    let filePreviewHtml = '';
    if (currentFile) {
        const isImg = currentFile.type.startsWith('image/');
        const isVid = currentFile.type.startsWith('video/');
        if (isImg) {
            const tempUrl = URL.createObjectURL(currentFile);
            filePreviewHtml = `<img src="${tempUrl}" class="ai-img-preview-msg" alt="${escapeHtml(currentFile.name)}">`;
        } else if (isVid) {
            const tempUrl = URL.createObjectURL(currentFile);
            filePreviewHtml = `<video src="${tempUrl}" controls style="max-width:280px; border-radius:8px; margin-bottom:8px; display:block;"></video>`;
        } else {
            filePreviewHtml = `
                <div class="ai-file-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    <span>${escapeHtml(currentFile.name)}</span>
                </div>
            `;
        }
    }

    const userHtml = `
        <div class="ai-msg-user">
            <div class="ai-msg-sender-user">
                <span>Anda • ${userTime}</span>
                <div class="user-avatar-small">${userInitials}</div>
            </div>
            <div class="ai-msg-bubble-user">
                ${filePreviewHtml}
                ${escapeHtml(userPrompt)}
            </div>
        </div>
    `;
    
    typingIndicator.insertAdjacentHTML('beforebegin', userHtml);
    typingIndicator.style.display = 'flex';
    scrollToBottom();

    const formData = new FormData();
    formData.append('prompt', userPrompt);
    if (currentFile) {
        formData.append('file', currentFile);
    }

    try {
        const response = await fetch('{{ route("asisten-ai.send") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();
        typingIndicator.style.display = 'none';

        if (data.success && data.assistant) {
            let structuredHtml = '';
            if (data.assistant.structured_data) {
                const s = data.assistant.structured_data;
                if (s.type === 'schedule' && s.items) {
                    structuredHtml = `<div class="ai-schedule-card">` +
                        s.items.map(item => `
                            <div class="ai-schedule-item">
                                <div class="ai-schedule-time">${escapeHtml(item.time)}</div>
                                <div class="ai-schedule-details">
                                    <span class="ai-schedule-title">${escapeHtml(item.title)}</span>
                                    <span class="ai-schedule-location">${escapeHtml(item.location)}</span>
                                </div>
                            </div>
                        `).join('') +
                    `</div>`;
                } else if (s.type === 'mail_summary' && s.items) {
                    structuredHtml = `<div class="ai-mail-card">` +
                        s.items.map(mail => `
                            <div class="ai-mail-item">
                                <span style="font-weight:600; color:#0f172a; font-size:12.5px;">${escapeHtml(mail.perihal)}</span>
                                <span style="font-size:11.5px; color:#64748b;">No: ${escapeHtml(mail.nomor)} • Pengirim: ${escapeHtml(mail.pengirim)} (${escapeHtml(mail.tanggal)})</span>
                            </div>
                        `).join('') +
                    `</div>`;
                }
            }

            const botHtml = `
                <div class="ai-msg-bot">
                    <div class="ai-msg-sender-bot">
                        <div class="bot-icon-small">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="12" height="12">
                                <path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.38-1 1.72V7h4a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3v-8a3 3 0 0 1 3-3h4V5.72A2.001 2.001 0 0 1 12 2zm-3 8a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm6 0a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-6.5 6a.75.75 0 0 0 0 1.5h7a.75.75 0 0 0 0-1.5h-7z"/>
                            </svg>
                        </div>
                        <span>Asisten AI • ${data.assistant.time}</span>
                    </div>
                    <div class="ai-msg-bubble-bot">
                        ${data.assistant.formatted_content || formatAiContent(data.assistant.content)}
                        ${structuredHtml}
                    </div>
                </div>
            `;
            typingIndicator.insertAdjacentHTML('beforebegin', botHtml);
        }
    } catch (err) {
        typingIndicator.style.display = 'none';
        const errorHtml = `
            <div class="ai-msg-bot">
                <div class="ai-msg-sender-bot">
                    <div class="bot-icon-small" style="background:#ef4444;">!</div>
                    <span>Asisten AI • Error</span>
                </div>
                <div class="ai-msg-bubble-bot" style="background:#fef2f2; border-color:#fecaca; color:#b91c1c;">
                    Maaf, terjadi kendala saat memproses berkas atau permintaan. Silakan coba lagi.
                </div>
            </div>
        `;
        typingIndicator.insertAdjacentHTML('beforebegin', errorHtml);
    } finally {
        inputField.disabled = false;
        sendBtn.disabled = false;
        inputField.focus();
        scrollToBottom();
    }
}

function formatAiContent(rawText) {
    if (!rawText) return '';
    let text = rawText;
    
    // Normalize newlines
    text = text.replace(/\r\n/g, '\n').replace(/\r/g, '\n');
    text = text.replace(/\n{3,}/g, '\n\n');

    // 1. Convert ***bold italic*** to <strong><em>...</em></strong>
    text = text.replace(/\*\*\*(.*?)\*\*\*/gs, '<strong><em>$1</em></strong>');
    // 2. Convert **bold** to <strong>...</strong>
    text = text.replace(/\*\*(.*?)\*\*/gs, '<strong>$1</strong>');
    // 3. Convert *italic* to <em>...</em>
    text = text.replace(/\*([^\*\n]+)\*/gs, '<em>$1</em>');
    // 4. Remove any remaining orphan * characters
    text = text.replace(/\*/g, '');
    // 5. Convert headers ###
    text = text.replace(/^### (.*)$/gm, '<strong style="display:block; margin:6px 0 2px 0;">$1</strong>');
    text = text.replace(/^## (.*)$/gm, '<strong style="display:block; margin:8px 0 3px 0; font-size:14px;">$1</strong>');
    text = text.replace(/^# (.*)$/gm, '<strong style="display:block; margin:10px 0 4px 0; font-size:15px;">$1</strong>');
    // 6. Convert horizontal rules ---
    text = text.replace(/^---+$/gm, '<hr style="border:none; border-top:1px solid #dbeafe; margin:8px 0;">');

    // Split into clean compact paragraphs
    const paragraphs = text.split(/\n\n+/);
    const html = paragraphs
        .map(p => p.trim())
        .filter(p => p.length > 0)
        .map(p => `<p style="margin:0 0 7px 0; line-height:1.5;">${p.replace(/\n/g, '<br>')}</p>`)
        .join('');

    return html || text.replace(/\n/g, '<br>');
}

function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
</script>
@endpush
