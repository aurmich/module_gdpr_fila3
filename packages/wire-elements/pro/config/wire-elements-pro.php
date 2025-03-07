<?php

declare(strict_types=1);

return [
    'default' => 'tailwind',

    'components' => [
        'modal' => [
            'view' => 'wire-elements-pro::modal.component',
            'property-resolvers' => [
                WireElements\Pro\Components\Modal\Resolvers\EnumPropertyResolver::class,
            ],
            'default-behavior' => [
                'close-on-escape' => true,
                'close-on-backdrop-click' => true,
                'trap-focus' => true,
                'remove-state-on-close' => false,
            ],
            'default-attributes' => [
                'size' => 'lg',
            ],
        ],
        'slide-over' => [
            'view' => 'wire-elements-pro::slide-over.component',
            'property-resolvers' => [
                WireElements\Pro\Components\Modal\Resolvers\EnumPropertyResolver::class,
            ],
            'default-behavior' => [
                'close-on-escape' => true,
                'close-on-backdrop-click' => true,
                'trap-focus' => true,
                'remove-state-on-close' => false,
            ],
            'default-attributes' => [
                'size' => 'md',
            ],
        ],
        'insert' => [
            'view' => 'wire-elements-pro::insert.component',
            'types' => [
                // 'user' => \App\UserInsert::class,
                // 'command' => \App\CommandInsert::class,
            ],
            'default-behavior' => [
                'debounce_milliseconds' => 200,
                'show_keyboard_instructions' => true,
            ],
        ],
        'spotlight' => [
            'view' => 'wire-elements-pro::spotlight.component',
            'default-behavior' => [
                'debounce_milliseconds' => 200,
                'shortcuts' => [
                    'k',
                    'slash',
                ],
            ],
        ],
    ],

    'presets' => [
        'tailwind' => [
            'modal' => [
                'size-map' => [
                    'xs' => 'max-w-xs',
                    'sm' => 'max-w-sm',
                    'md' => 'max-w-md',
                    'lg' => 'max-w-lg',
                    'xl' => 'max-w-xl',
                    '2xl' => 'max-w-2xl',
                    '3xl' => 'max-w-3xl',
                    '4xl' => 'max-w-4xl',
                    '5xl' => 'max-w-5xl',
                    '6xl' => 'max-w-6xl',
                    '7xl' => 'max-w-7xl',
                    'fullscreen' => 'fullscreen',
                ],
                'confirmation_view' => 'wire-elements-pro::modal.tailwind.confirmation',
            ],
            'slide-over' => [
                'size-map' => [
                    'xs' => 'max-w-xs',
                    'sm' => 'max-w-sm',
                    'md' => 'max-w-md',
                    'lg' => 'max-w-lg',
                    'xl' => 'max-w-xl',
                    '2xl' => 'max-w-2xl',
                    '3xl' => 'max-w-3xl',
                    '4xl' => 'max-w-4xl',
                    '5xl' => 'max-w-5xl',
                    '6xl' => 'max-w-6xl',
                    '7xl' => 'max-w-7xl',
                ],
            ],
        ],
        'bootstrap' => [
            'modal' => [
                'size-map' => [
                    'xs' => 'wep-modal-content-xs',
                    'sm' => 'wep-modal-content-sm',
                    'md' => 'wep-modal-content-md',
                    'lg' => 'wep-modal-content-lg',
                    'xl' => 'wep-modal-content-xl',
                    '2xl' => 'wep-modal-content-2xl',
                    '3xl' => 'wep-modal-content-3xl',
                    '4xl' => 'wep-modal-content-4xl',
                    '5xl' => 'wep-modal-content-5xl',
                    '6xl' => 'wep-modal-content-6xl',
                    '7xl' => 'wep-modal-content-7xl',
                    'fullscreen' => 'wep-modal-content-fullscreen',
                ],
                'confirmation_view' => 'wire-elements-pro::modal.bootstrap.confirmation',
            ],
            'slide-over' => [
                'size-map' => [
                    'xs' => 'wep-slide-over-content-xs',
                    'sm' => 'wep-slide-over-content-sm',
                    'md' => 'wep-slide-over-content-md',
                    'lg' => 'wep-slide-over-content-lg',
                    'xl' => 'wep-slide-over-content-xl',
                    '2xl' => 'wep-slide-over-content-2xl',
                    '3xl' => 'wep-slide-over-content-3xl',
                    '4xl' => 'wep-slide-over-content-4xl',
                    '5xl' => 'wep-slide-over-content-5xl',
                    '6xl' => 'wep-slide-over-content-6xl',
                    '7xl' => 'wep-slide-over-content-7xl',
                ],
            ],
        ],
    ],

    'icons' => [
        'academic-cap' => WireElements\Pro\Icons\AcademicCap::class,
        'adjustments-horizontal' => WireElements\Pro\Icons\AdjustmentsHorizontal::class,
        'adjustments-vertical' => WireElements\Pro\Icons\AdjustmentsVertical::class,
        'archive-box-arrow-down' => WireElements\Pro\Icons\ArchiveBoxArrowDown::class,
        'archive-box-x-mark' => WireElements\Pro\Icons\ArchiveBoxXMark::class,
        'archive-box' => WireElements\Pro\Icons\ArchiveBox::class,
        'arrow-down-circle' => WireElements\Pro\Icons\ArrowDownCircle::class,
        'arrow-down-left' => WireElements\Pro\Icons\ArrowDownLeft::class,
        'arrow-down-on-square-stack' => WireElements\Pro\Icons\ArrowDownOnSquareStack::class,
        'arrow-down-on-square' => WireElements\Pro\Icons\ArrowDownOnSquare::class,
        'arrow-down-right' => WireElements\Pro\Icons\ArrowDownRight::class,
        'arrow-down-tray' => WireElements\Pro\Icons\ArrowDownTray::class,
        'arrow-down' => WireElements\Pro\Icons\ArrowDown::class,
        'arrow-left-circle' => WireElements\Pro\Icons\ArrowLeftCircle::class,
        'arrow-left-on-rectangle' => WireElements\Pro\Icons\ArrowLeftOnRectangle::class,
        'arrow-left' => WireElements\Pro\Icons\ArrowLeft::class,
        'arrow-long-down' => WireElements\Pro\Icons\ArrowLongDown::class,
        'arrow-long-left' => WireElements\Pro\Icons\ArrowLongLeft::class,
        'arrow-long-right' => WireElements\Pro\Icons\ArrowLongRight::class,
        'arrow-long-up' => WireElements\Pro\Icons\ArrowLongUp::class,
        'arrow-path-rounded-square' => WireElements\Pro\Icons\ArrowPathRoundedSquare::class,
        'arrow-path' => WireElements\Pro\Icons\ArrowPath::class,
        'arrow-right-circle' => WireElements\Pro\Icons\ArrowRightCircle::class,
        'arrow-right-on-rectangle' => WireElements\Pro\Icons\ArrowRightOnRectangle::class,
        'arrow-right' => WireElements\Pro\Icons\ArrowRight::class,
        'arrow-small-down' => WireElements\Pro\Icons\ArrowSmallDown::class,
        'arrow-small-left' => WireElements\Pro\Icons\ArrowSmallLeft::class,
        'arrow-small-right' => WireElements\Pro\Icons\ArrowSmallRight::class,
        'arrow-small-up' => WireElements\Pro\Icons\ArrowSmallUp::class,
        'arrow-top-right-on-square' => WireElements\Pro\Icons\ArrowTopRightOnSquare::class,
        'arrow-trending-down' => WireElements\Pro\Icons\ArrowTrendingDown::class,
        'arrow-trending-up' => WireElements\Pro\Icons\ArrowTrendingUp::class,
        'arrow-up-circle' => WireElements\Pro\Icons\ArrowUpCircle::class,
        'arrow-up-left' => WireElements\Pro\Icons\ArrowUpLeft::class,
        'arrow-up-on-square-stack' => WireElements\Pro\Icons\ArrowUpOnSquareStack::class,
        'arrow-up-on-square' => WireElements\Pro\Icons\ArrowUpOnSquare::class,
        'arrow-up-right' => WireElements\Pro\Icons\ArrowUpRight::class,
        'arrow-up-tray' => WireElements\Pro\Icons\ArrowUpTray::class,
        'arrow-up' => WireElements\Pro\Icons\ArrowUp::class,
        'arrow-uturn-down' => WireElements\Pro\Icons\ArrowUturnDown::class,
        'arrow-uturn-left' => WireElements\Pro\Icons\ArrowUturnLeft::class,
        'arrow-uturn-right' => WireElements\Pro\Icons\ArrowUturnRight::class,
        'arrow-uturn-up' => WireElements\Pro\Icons\ArrowUturnUp::class,
        'arrows-pointing-in' => WireElements\Pro\Icons\ArrowsPointingIn::class,
        'arrows-pointing-out' => WireElements\Pro\Icons\ArrowsPointingOut::class,
        'arrows-right-left' => WireElements\Pro\Icons\ArrowsRightLeft::class,
        'arrows-up-down' => WireElements\Pro\Icons\ArrowsUpDown::class,
        'at-symbol' => WireElements\Pro\Icons\AtSymbol::class,
        'backspace' => WireElements\Pro\Icons\Backspace::class,
        'backward' => WireElements\Pro\Icons\Backward::class,
        'banknotes' => WireElements\Pro\Icons\Banknotes::class,
        'bars-2' => WireElements\Pro\Icons\Bars2::class,
        'bars-3-bottom-left' => WireElements\Pro\Icons\Bars3BottomLeft::class,
        'bars-3-bottom-right' => WireElements\Pro\Icons\Bars3BottomRight::class,
        'bars-3-center-left' => WireElements\Pro\Icons\Bars3CenterLeft::class,
        'bars-3' => WireElements\Pro\Icons\Bars3::class,
        'bars-4' => WireElements\Pro\Icons\Bars4::class,
        'bars-arrow-down' => WireElements\Pro\Icons\BarsArrowDown::class,
        'bars-arrow-up' => WireElements\Pro\Icons\BarsArrowUp::class,
        'battery-0' => WireElements\Pro\Icons\Battery0::class,
        'battery-100' => WireElements\Pro\Icons\Battery100::class,
        'battery-50' => WireElements\Pro\Icons\Battery50::class,
        'beaker' => WireElements\Pro\Icons\Beaker::class,
        'bell-alert' => WireElements\Pro\Icons\BellAlert::class,
        'bell-slash' => WireElements\Pro\Icons\BellSlash::class,
        'bell-snooze' => WireElements\Pro\Icons\BellSnooze::class,
        'bell' => WireElements\Pro\Icons\Bell::class,
        'bolt-slash' => WireElements\Pro\Icons\BoltSlash::class,
        'bolt' => WireElements\Pro\Icons\Bolt::class,
        'book-open' => WireElements\Pro\Icons\BookOpen::class,
        'bookmark-slash' => WireElements\Pro\Icons\BookmarkSlash::class,
        'bookmark-square' => WireElements\Pro\Icons\BookmarkSquare::class,
        'bookmark' => WireElements\Pro\Icons\Bookmark::class,
        'briefcase' => WireElements\Pro\Icons\Briefcase::class,
        'bug-ant' => WireElements\Pro\Icons\BugAnt::class,
        'building-library' => WireElements\Pro\Icons\BuildingLibrary::class,
        'building-office-2' => WireElements\Pro\Icons\BuildingOffice2::class,
        'building-office' => WireElements\Pro\Icons\BuildingOffice::class,
        'building-storefront' => WireElements\Pro\Icons\BuildingStorefront::class,
        'cake' => WireElements\Pro\Icons\Cake::class,
        'calculator' => WireElements\Pro\Icons\Calculator::class,
        'calendar-days' => WireElements\Pro\Icons\CalendarDays::class,
        'calendar' => WireElements\Pro\Icons\Calendar::class,
        'camera' => WireElements\Pro\Icons\Camera::class,
        'chart-bar-square' => WireElements\Pro\Icons\ChartBarSquare::class,
        'chart-bar' => WireElements\Pro\Icons\ChartBar::class,
        'chart-pie' => WireElements\Pro\Icons\ChartPie::class,
        'chat-bubble-bottom-center-text' => WireElements\Pro\Icons\ChatBubbleBottomCenterText::class,
        'chat-bubble-bottom-center' => WireElements\Pro\Icons\ChatBubbleBottomCenter::class,
        'chat-bubble-left-ellipsis' => WireElements\Pro\Icons\ChatBubbleLeftEllipsis::class,
        'chat-bubble-left-right' => WireElements\Pro\Icons\ChatBubbleLeftRight::class,
        'chat-bubble-left' => WireElements\Pro\Icons\ChatBubbleLeft::class,
        'chat-bubble-oval-left-ellipsis' => WireElements\Pro\Icons\ChatBubbleOvalLeftEllipsis::class,
        'chat-bubble-oval-left' => WireElements\Pro\Icons\ChatBubbleOvalLeft::class,
        'check-badge' => WireElements\Pro\Icons\CheckBadge::class,
        'check-circle' => WireElements\Pro\Icons\CheckCircle::class,
        'check' => WireElements\Pro\Icons\Check::class,
        'chevron-double-down' => WireElements\Pro\Icons\ChevronDoubleDown::class,
        'chevron-double-left' => WireElements\Pro\Icons\ChevronDoubleLeft::class,
        'chevron-double-right' => WireElements\Pro\Icons\ChevronDoubleRight::class,
        'chevron-double-up' => WireElements\Pro\Icons\ChevronDoubleUp::class,
        'chevron-down' => WireElements\Pro\Icons\ChevronDown::class,
        'chevron-left' => WireElements\Pro\Icons\ChevronLeft::class,
        'chevron-right' => WireElements\Pro\Icons\ChevronRight::class,
        'chevron-up-down' => WireElements\Pro\Icons\ChevronUpDown::class,
        'chevron-up' => WireElements\Pro\Icons\ChevronUp::class,
        'circle-stack' => WireElements\Pro\Icons\CircleStack::class,
        'clipboard-document-check' => WireElements\Pro\Icons\ClipboardDocumentCheck::class,
        'clipboard-document-list' => WireElements\Pro\Icons\ClipboardDocumentList::class,
        'clipboard-document' => WireElements\Pro\Icons\ClipboardDocument::class,
        'clipboard' => WireElements\Pro\Icons\Clipboard::class,
        'clock' => WireElements\Pro\Icons\Clock::class,
        'cloud-arrow-down' => WireElements\Pro\Icons\CloudArrowDown::class,
        'cloud-arrow-up' => WireElements\Pro\Icons\CloudArrowUp::class,
        'cloud' => WireElements\Pro\Icons\Cloud::class,
        'code-bracket-square' => WireElements\Pro\Icons\CodeBracketSquare::class,
        'code-bracket' => WireElements\Pro\Icons\CodeBracket::class,
        'cog-6-tooth' => WireElements\Pro\Icons\Cog6Tooth::class,
        'cog-8-tooth' => WireElements\Pro\Icons\Cog8Tooth::class,
        'cog' => WireElements\Pro\Icons\Cog::class,
        'command-line' => WireElements\Pro\Icons\CommandLine::class,
        'computer-desktop' => WireElements\Pro\Icons\ComputerDesktop::class,
        'cpu-chip' => WireElements\Pro\Icons\CpuChip::class,
        'credit-card' => WireElements\Pro\Icons\CreditCard::class,
        'cube-transparent' => WireElements\Pro\Icons\CubeTransparent::class,
        'cube' => WireElements\Pro\Icons\Cube::class,
        'currency-bangladeshi' => WireElements\Pro\Icons\CurrencyBangladeshi::class,
        'currency-dollar' => WireElements\Pro\Icons\CurrencyDollar::class,
        'currency-euro' => WireElements\Pro\Icons\CurrencyEuro::class,
        'currency-pound' => WireElements\Pro\Icons\CurrencyPound::class,
        'currency-rupee' => WireElements\Pro\Icons\CurrencyRupee::class,
        'currency-yen' => WireElements\Pro\Icons\CurrencyYen::class,
        'cursor-arrow-rays' => WireElements\Pro\Icons\CursorArrowRays::class,
        'cursor-arrow-ripple' => WireElements\Pro\Icons\CursorArrowRipple::class,
        'device-phone-mobile' => WireElements\Pro\Icons\DevicePhoneMobile::class,
        'device-tablet' => WireElements\Pro\Icons\DeviceTablet::class,
        'document-arrow-down' => WireElements\Pro\Icons\DocumentArrowDown::class,
        'document-arrow-up' => WireElements\Pro\Icons\DocumentArrowUp::class,
        'document-chart-bar' => WireElements\Pro\Icons\DocumentChartBar::class,
        'document-check' => WireElements\Pro\Icons\DocumentCheck::class,
        'document-duplicate' => WireElements\Pro\Icons\DocumentDuplicate::class,
        'document-magnifying-glass' => WireElements\Pro\Icons\DocumentMagnifyingGlass::class,
        'document-minus' => WireElements\Pro\Icons\DocumentMinus::class,
        'document-plus' => WireElements\Pro\Icons\DocumentPlus::class,
        'document-text' => WireElements\Pro\Icons\DocumentText::class,
        'document' => WireElements\Pro\Icons\Document::class,
        'ellipsis-horizontal-circle' => WireElements\Pro\Icons\EllipsisHorizontalCircle::class,
        'ellipsis-horizontal' => WireElements\Pro\Icons\EllipsisHorizontal::class,
        'ellipsis-vertical' => WireElements\Pro\Icons\EllipsisVertical::class,
        'envelope-open' => WireElements\Pro\Icons\EnvelopeOpen::class,
        'envelope' => WireElements\Pro\Icons\Envelope::class,
        'exclamation-circle' => WireElements\Pro\Icons\ExclamationCircle::class,
        'exclamation-triangle' => WireElements\Pro\Icons\ExclamationTriangle::class,
        'eye-dropper' => WireElements\Pro\Icons\EyeDropper::class,
        'eye-slash' => WireElements\Pro\Icons\EyeSlash::class,
        'eye' => WireElements\Pro\Icons\Eye::class,
        'face-frown' => WireElements\Pro\Icons\FaceFrown::class,
        'face-smile' => WireElements\Pro\Icons\FaceSmile::class,
        'film' => WireElements\Pro\Icons\Film::class,
        'finger-print' => WireElements\Pro\Icons\FingerPrint::class,
        'fire' => WireElements\Pro\Icons\Fire::class,
        'flag' => WireElements\Pro\Icons\Flag::class,
        'folder-arrow-down' => WireElements\Pro\Icons\FolderArrowDown::class,
        'folder-minus' => WireElements\Pro\Icons\FolderMinus::class,
        'folder-open' => WireElements\Pro\Icons\FolderOpen::class,
        'folder-plus' => WireElements\Pro\Icons\FolderPlus::class,
        'folder' => WireElements\Pro\Icons\Folder::class,
        'forward' => WireElements\Pro\Icons\Forward::class,
        'funnel' => WireElements\Pro\Icons\Funnel::class,
        'gif' => WireElements\Pro\Icons\Gif::class,
        'gift-top' => WireElements\Pro\Icons\GiftTop::class,
        'gift' => WireElements\Pro\Icons\Gift::class,
        'globe-alt' => WireElements\Pro\Icons\GlobeAlt::class,
        'globe-americas' => WireElements\Pro\Icons\GlobeAmericas::class,
        'globe-asia-australia' => WireElements\Pro\Icons\GlobeAsiaAustralia::class,
        'globe-europe-africa' => WireElements\Pro\Icons\GlobeEuropeAfrica::class,
        'hand-raised' => WireElements\Pro\Icons\HandRaised::class,
        'hand-thumb-down' => WireElements\Pro\Icons\HandThumbDown::class,
        'hand-thumb-up' => WireElements\Pro\Icons\HandThumbUp::class,
        'hashtag' => WireElements\Pro\Icons\Hashtag::class,
        'heart' => WireElements\Pro\Icons\Heart::class,
        'home-modern' => WireElements\Pro\Icons\HomeModern::class,
        'home' => WireElements\Pro\Icons\Home::class,
        'identification' => WireElements\Pro\Icons\Identification::class,
        'inbox-arrow-down' => WireElements\Pro\Icons\InboxArrowDown::class,
        'inbox-stack' => WireElements\Pro\Icons\InboxStack::class,
        'inbox' => WireElements\Pro\Icons\Inbox::class,
        'information-circle' => WireElements\Pro\Icons\InformationCircle::class,
        'key' => WireElements\Pro\Icons\Key::class,
        'language' => WireElements\Pro\Icons\Language::class,
        'lifebuoy' => WireElements\Pro\Icons\Lifebuoy::class,
        'light-bulb' => WireElements\Pro\Icons\LightBulb::class,
        'link' => WireElements\Pro\Icons\Link::class,
        'list-bullet' => WireElements\Pro\Icons\ListBullet::class,
        'lock-closed' => WireElements\Pro\Icons\LockClosed::class,
        'lock-open' => WireElements\Pro\Icons\LockOpen::class,
        'magnifying-glass-circle' => WireElements\Pro\Icons\MagnifyingGlassCircle::class,
        'magnifying-glass-minus' => WireElements\Pro\Icons\MagnifyingGlassMinus::class,
        'magnifying-glass-plus' => WireElements\Pro\Icons\MagnifyingGlassPlus::class,
        'magnifying-glass' => WireElements\Pro\Icons\MagnifyingGlass::class,
        'map-pin' => WireElements\Pro\Icons\MapPin::class,
        'map' => WireElements\Pro\Icons\Map::class,
        'megaphone' => WireElements\Pro\Icons\Megaphone::class,
        'microphone' => WireElements\Pro\Icons\Microphone::class,
        'minus-circle' => WireElements\Pro\Icons\MinusCircle::class,
        'minus-small' => WireElements\Pro\Icons\MinusSmall::class,
        'minus' => WireElements\Pro\Icons\Minus::class,
        'moon' => WireElements\Pro\Icons\Moon::class,
        'musical-note' => WireElements\Pro\Icons\MusicalNote::class,
        'newspaper' => WireElements\Pro\Icons\Newspaper::class,
        'no-symbol' => WireElements\Pro\Icons\NoSymbol::class,
        'paint-brush' => WireElements\Pro\Icons\PaintBrush::class,
        'paper-airplane' => WireElements\Pro\Icons\PaperAirplane::class,
        'paper-clip' => WireElements\Pro\Icons\PaperClip::class,
        'pause-circle' => WireElements\Pro\Icons\PauseCircle::class,
        'pause' => WireElements\Pro\Icons\Pause::class,
        'pencil-square' => WireElements\Pro\Icons\PencilSquare::class,
        'pencil' => WireElements\Pro\Icons\Pencil::class,
        'phone-arrow-down-left' => WireElements\Pro\Icons\PhoneArrowDownLeft::class,
        'phone-arrow-up-right' => WireElements\Pro\Icons\PhoneArrowUpRight::class,
        'phone-x-mark' => WireElements\Pro\Icons\PhoneXMark::class,
        'phone' => WireElements\Pro\Icons\Phone::class,
        'photo' => WireElements\Pro\Icons\Photo::class,
        'play-circle' => WireElements\Pro\Icons\PlayCircle::class,
        'play-pause' => WireElements\Pro\Icons\PlayPause::class,
        'play' => WireElements\Pro\Icons\Play::class,
        'plus-circle' => WireElements\Pro\Icons\PlusCircle::class,
        'plus-small' => WireElements\Pro\Icons\PlusSmall::class,
        'plus' => WireElements\Pro\Icons\Plus::class,
        'power' => WireElements\Pro\Icons\Power::class,
        'presentation-chart-bar' => WireElements\Pro\Icons\PresentationChartBar::class,
        'presentation-chart-line' => WireElements\Pro\Icons\PresentationChartLine::class,
        'printer' => WireElements\Pro\Icons\Printer::class,
        'puzzle-piece' => WireElements\Pro\Icons\PuzzlePiece::class,
        'qr-code' => WireElements\Pro\Icons\QrCode::class,
        'question-mark-circle' => WireElements\Pro\Icons\QuestionMarkCircle::class,
        'queue-list' => WireElements\Pro\Icons\QueueList::class,
        'radio' => WireElements\Pro\Icons\Radio::class,
        'receipt-percent' => WireElements\Pro\Icons\ReceiptPercent::class,
        'receipt-refund' => WireElements\Pro\Icons\ReceiptRefund::class,
        'rectangle-group' => WireElements\Pro\Icons\RectangleGroup::class,
        'rectangle-stack' => WireElements\Pro\Icons\RectangleStack::class,
        'rocket-launch' => WireElements\Pro\Icons\RocketLaunch::class,
        'rss' => WireElements\Pro\Icons\Rss::class,
        'scale' => WireElements\Pro\Icons\Scale::class,
        'scissors' => WireElements\Pro\Icons\Scissors::class,
        'server-stack' => WireElements\Pro\Icons\ServerStack::class,
        'server' => WireElements\Pro\Icons\Server::class,
        'share' => WireElements\Pro\Icons\Share::class,
        'shield-check' => WireElements\Pro\Icons\ShieldCheck::class,
        'shield-exclamation' => WireElements\Pro\Icons\ShieldExclamation::class,
        'shopping-bag' => WireElements\Pro\Icons\ShoppingBag::class,
        'shopping-cart' => WireElements\Pro\Icons\ShoppingCart::class,
        'signal-slash' => WireElements\Pro\Icons\SignalSlash::class,
        'signal' => WireElements\Pro\Icons\Signal::class,
        'sparkles' => WireElements\Pro\Icons\Sparkles::class,
        'speaker-wave' => WireElements\Pro\Icons\SpeakerWave::class,
        'speaker-x-mark' => WireElements\Pro\Icons\SpeakerXMark::class,
        'square-2-stack' => WireElements\Pro\Icons\Square2Stack::class,
        'square-3-stack-3d' => WireElements\Pro\Icons\Square3Stack3d::class,
        'squares-2x2' => WireElements\Pro\Icons\Squares2x2::class,
        'squares-plus' => WireElements\Pro\Icons\SquaresPlus::class,
        'star' => WireElements\Pro\Icons\Star::class,
        'stop-circle' => WireElements\Pro\Icons\StopCircle::class,
        'stop' => WireElements\Pro\Icons\Stop::class,
        'sun' => WireElements\Pro\Icons\Sun::class,
        'swatch' => WireElements\Pro\Icons\Swatch::class,
        'table-cells' => WireElements\Pro\Icons\TableCells::class,
        'tag' => WireElements\Pro\Icons\Tag::class,
        'ticket' => WireElements\Pro\Icons\Ticket::class,
        'trash' => WireElements\Pro\Icons\Trash::class,
        'trophy' => WireElements\Pro\Icons\Trophy::class,
        'truck' => WireElements\Pro\Icons\Truck::class,
        'tv' => WireElements\Pro\Icons\Tv::class,
        'user-circle' => WireElements\Pro\Icons\UserCircle::class,
        'user-group' => WireElements\Pro\Icons\UserGroup::class,
        'user-minus' => WireElements\Pro\Icons\UserMinus::class,
        'user-plus' => WireElements\Pro\Icons\UserPlus::class,
        'user' => WireElements\Pro\Icons\User::class,
        'users' => WireElements\Pro\Icons\Users::class,
        'variable' => WireElements\Pro\Icons\Variable::class,
        'video-camera-slash' => WireElements\Pro\Icons\VideoCameraSlash::class,
        'video-camera' => WireElements\Pro\Icons\VideoCamera::class,
        'view-columns' => WireElements\Pro\Icons\ViewColumns::class,
        'viewfinder-circle' => WireElements\Pro\Icons\ViewfinderCircle::class,
        'wallet' => WireElements\Pro\Icons\Wallet::class,
        'wifi' => WireElements\Pro\Icons\Wifi::class,
        'window' => WireElements\Pro\Icons\Window::class,
        'wrench-screwdriver' => WireElements\Pro\Icons\WrenchScrewdriver::class,
        'wrench' => WireElements\Pro\Icons\Wrench::class,
        'x-circle' => WireElements\Pro\Icons\XCircle::class,
        'x-mark' => WireElements\Pro\Icons\XMark::class,
    ],
];
