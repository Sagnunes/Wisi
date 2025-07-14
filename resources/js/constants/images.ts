interface ImageItem {
    src: string;
    alt: string;
}

const IMAGES: Record<string, ImageItem> = {
    logo: {
        src: '/images/logo-wisi-small.png',
        alt: 'logo-wisi',
    },
    welcomeCard: {
        src: '/images/background_deposit.jpg',
        alt: 'welcome card image',
    },
};

export { IMAGES };
