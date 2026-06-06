CREATE TABLE IF NOT EXISTS pharmacy.analytics_events
(
    occurred_at DateTime,
    event_name LowCardinality(String),
    actor_id Nullable(UInt64),
    subject_type LowCardinality(String),
    subject_id Nullable(UInt64),
    payload String
)
ENGINE = MergeTree
PARTITION BY toYYYYMM(occurred_at)
ORDER BY (event_name, occurred_at);
