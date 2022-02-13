<?php

namespace Domain\Subscriber\DataTransferObjects;

use Domain\Subscriber\Models\Form;
use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class SubscriberData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $email,
        public readonly string $first_name,
        public readonly ?string $last_name,
        /** @var DataCollection<TagData> */
        public readonly null|Lazy|DataCollection $tags,
        public readonly null|Lazy|FormData $form,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->all(),
            'tags' => TagData::collection(Tag::whereIn('id', $request->collect('tag_ids'))->get()),
            'form' => FormData::from(Form::find($request->form_id)),
        ]);
    }

    public static function fromModel(Subscriber $subscriber): self
    {
        return self::from([
            ...$subscriber->toArray(),
            'tags' => Lazy::whenLoaded('tags', $subscriber, fn () => TagData::collection($subscriber->tags)),
            'form' => Lazy::whenLoaded('form', $subscriber, fn () => FormData::from($subscriber->form)),
        ]);
    }

    public static function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('subscribers', 'email')->ignore(request('subscriber')),
            ],
            'first_name' => ['required', 'string'],
            'last_name' => ['nullable', 'sometimes', 'string'],
            'tags' => ['nullable', 'sometimes', 'array'],
            'form_id' => ['nullable', 'sometimes', 'exists:forms,id'],
        ];
    }
}
