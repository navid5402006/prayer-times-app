<div class="reply-card" id="reply-{{ $reply->id }}">
    <div class="reply-header">
        <img src="{{ $reply->user->avatar_url }}" class="reply-avatar" alt="{{ $reply->user->name }}">
        <span class="reply-author">{{ $reply->user->name }}</span>
        <span class="reply-date">{{ $reply->created_at->diffForHumans() }}</span>
    </div>
    <div class="reply-text" id="reply-text-{{ $reply->id }}">
        {{ $reply->content }}
    </div>
    @if(Auth::id() == $reply->user_id)
        <div class="reply-actions">
            <button class="comment-action-btn" onclick="editReply({{ $reply->id }})">
                <i class="fas fa-edit"></i> Edit
            </button>
            <button class="comment-action-btn text-danger" onclick="deleteReply({{ $reply->id }})">
                <i class="fas fa-trash"></i> Delete
            </button>
        </div>
    @endif
</div>