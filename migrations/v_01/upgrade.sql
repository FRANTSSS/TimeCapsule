CREATE TABLE "themes"
(
    id uuid DEFAULT gen_random_uuid() NOT NULL
        PRIMARY KEY,
    name VARCHAR NOT NULL
);

CREATE TABLE "tags"
(
    id uuid DEFAULT gen_random_uuid() NOT NULL
    PRIMARY KEY,
    name VARCHAR NOT NULL
);

CREATE TABLE "groups"
(
    id uuid DEFAULT gen_random_uuid() NOT NULL
    PRIMARY KEY,
    name VARCHAR NOT NULL
);

CREATE TABLE "events"
(
    id uuid DEFAULT gen_random_uuid() NOT NULL
        CONSTRAINT event_pk
        PRIMARY KEY,
    name VARCHAR NOT NULL,
    description text,
    "ThemeId" uuid
        CONSTRAINT event_theme_id_fk
        REFERENCES themes,
    "GroupId" uuid NOT NULL
        CONSTRAINT event_group_id_fk
        REFERENCES "groups"
);

CREATE TABLE "dates_events"
(
    "EventId" uuid NOT NULL
        CONSTRAINT dates_events_event_id_fk
        REFERENCES events,
    date DATE NOT NULL
);

CREATE TABLE "tags_events"
(
    "TagId" uuid
        CONSTRAINT tags_events_tag_id_fk
        REFERENCES tags,
    "EventId" uuid
        CONSTRAINT tags_events_event_id_fk
        REFERENCES events
);
